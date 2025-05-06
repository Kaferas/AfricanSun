@extends('app.template')

@section('title',"Liste des Kits")


@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Liste des Kits </h2>
                
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Kits</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des Kits</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2 mt-3">
                            <h4 class="text-center">Liste des Kits</h4>
                        </div>
                        
                        <form class="col-md-10" action="{{ route('kit.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-8">
                                    <div id="custom-search" class="top-search-bar">
                                        <input class="form-control" type="text" placeholder="Search.." name="search" value="{{ old('search',$search) }}">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('kit.index') }}" class="btn btn-light"><i class="fas fa-redo"></i></a>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <a data-href="{{ route('kit.store') }}" onclick="handleOpenModal(this)" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Numero de Serie du Kit</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Créé Par</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kits as $value)
                                        <tr>
                                            <td>{{ $value->customer->customer_firstname .' '.$value->customer->customer_lastname }}</td>
                                            <td>{{ $value->kit_serial_number }}</td>
                                            <td>
                                                @if ($value->kit_status == 0)
                                                    <span class="badge badge-primary">Locked</span>
                                                @else
                                                    <span class="badge badge-success">UnLocked</span>
                                                @endif
                                            </td>
                                            <td>{{ $value->user->name }}</td>
                                            <td>{{ $value->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                
                                                <a data-href="{{ route('kit.update',$value->id) }}" onclick="handleOpenModal(this)" data-value="{{ json_encode($value) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a data-href="{{ route('kit.destroy',$value->id) }}" onclick="handleDelete(this)" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <section>
        <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-labelledby="modalMetropoleLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appModalFromLabel"></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kit.store') }}" method="POST" id="modalForm">
                            @csrf
                            <div class="form-group">
                                <label for="customer_id">Client</label>
                                <select id="customer_id" name="customer_id"
                                    class="select2 form-control @error('customer_id') is-invalid @enderror">
                                    <option selected disabled>Sélectionnez un client</option>
                                    @foreach ($customerList as $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->customer_firstname .' '.$value->customer_lastname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kit_serial_number">Numero de Serie du Kit</label>
                                <input type="text" name="kit_serial_number" id="kit_serial_number" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" onclick="handleSaveData(this)">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js_content')

<script>

    function handleOpenModal(th) {
        var href = $(th).data('href');
        var data = $(th).data('value');
        $('#appModalFromLabel').text(href == "{{ route('kit.store') }}" ? "Ajouter un Kit" :
            "Modifier un Kit");
        $('#customer_id').val(href == "{{ route('kit.store') }}" ? '' : data.customer_id);
        $('#kit_serial_number').val(href == "{{ route('kit.store') }}" ? '' : data.kit_serial_number).trigger('change');
        $('#modalForm').attr('action', href);
        $('#modalForm').attr('method', href == "{{ route('kit.store') }}" ? 'POST' : 'PUT');
        $('#appFormModal').modal('show');
    }

    function handleSaveData(th) {
        $(th).prop('disabled', true);
        var form_data = $('#modalForm');

        $.ajax({
            url: form_data.attr('action'),
            method: form_data.attr('method'),
            data: form_data.serialize(),
            success: function(response) {
                response = typeof response == 'string' ? JSON.parse(response) : response;
                if (response.success) {
                    $('#appFormModal').modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.messages,
                        showConfirmButton: false,
                        timer: 5000
                    });
                    window.location.reload();
                } else {
                    handleErrors(response);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                handleErrors(xhr.responseJSON);
            },
            complete: function() {
                $(th).prop('disabled', false);
            }
        });
    }

    function handleDelete(th) {
        var url = $(th).data('href');

        Swal.fire({
            title: "Etes vous sur de vouloir supprimer les données?",
            icon: 'warning',
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: `Non,Annuler`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'delete',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        response = typeof response == 'string' ? JSON.parse(response) : response;
                        if (response.success) {
                            $(th).attr('disabled', false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.messages,
                                showConfirmButton: false,
                                timer: 5000
                            });
                            window.location.reload();

                        } else {
                            handleErrors(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        handleErrors(xhr.responseJSON);
                    },
                    complete: function() {
                        $(th).prop('disabled', false);
                    }
                });
            }
        });
    }

    function handleErrors(data) {
        var errors = Object.values(data.messages);
        var html = "<ul class='list-group'>";
        errors.forEach(element => {
            html += `<li class="list-group-item text-danger">${element}</li>`;
        });
        html += "</ul>";
        Swal.fire({
            icon: 'error',
            title: "Oups,il y a des erreurs",
            html: html,
        });

    }
</script>

@endsection
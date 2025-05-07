@extends('app.template')

@section('title','Liste des Clients')

@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Liste des Clients </h2>

                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Clients</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des clients</li>
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
                            <h4 class="text-center">Liste des Clients</h4>
                        </div>

                        <form class="col-md-10" action="{{ route('customer.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div id="custom-search" class="top-search-bar">
                                        <label for="province">Recherche</label>
                                        <input class="form-control" type="text" placeholder="Search.." name="search" value="{{ old('search',$search) }}">
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <select id="province" name="province" onchange="triggerCommune()"
                                            class="select2 form-control">
                                            <option selected disabled>Sélectionnez une province</option>
                                            @foreach ($provinces as $value)
                                                <option value="{{ $value->region }}"
                                                    {{ old('province', $province ?? '') == $value->region ? 'selected' : '' }}>
                                                    {{ $value->region }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="form-group externeC" hidden>
                                        <label for="commune">Commune</label>
                                        <select id="commune" name="commune"  class="select2 form-control " >
                                            <option selected disabled>Sélectionnez une commune</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('customer.index') }}" class="btn btn-light"><i class="fas fa-redo"></i></a>
                                    <a href="{{ route('customer.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="card-content" id="customerList">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom/Prenom</th>
                                        <th scope="col">Province</th>
                                        <th scope="col">Commune</th>
                                        <th scope="col">Telephone</th>
                                        <th scope="col">Créé Par</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $value)
                                        <tr>
                                            <td>{{ $value->customer_firstname .' '.$value->customer_lastname }}</td>
                                            <td>{{ $value->customer_province }}</td>
                                            <td>{{ $value->customer_commune }}</td>
                                            <td>{{ $value->customer_phone }}</td>
                                            <td>{{ $value->user->name }}</td>
                                            <td>{{ $value->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('customer.show',$value->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('customer.edit',$value->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a data-href="{{ route('customer.destroy',$value->id) }}" onclick="handleDelete(this)" class="btn btn-danger btn-sm">
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

@endsection

@section('js_content')
    <script>
        var selectedProvince = "<?= $province ?>";
        var selectedCommune = "<?= $commune ?>";

        function triggerCommune() {
            let province = $("#province").val()
            // $(".externeQ").attr("hidden", true)
            $.ajax({
                url: "{{ url('communeOfProvince') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    province: province
                },
                success: function(data) {
                    $("#commune").find('option').remove().end();
                    $(".externeC").attr("hidden", false);
                    $("#commune").append(
                            `<option selected disabled>Sélectionnez une commune</option>`)
                    $.each(data, function(key, value) {
                        $("#commune").append(
                            `<option ${selectedCommune == value.district ? 'selected' : ''} value='${value.district}'>${value.district}</option>`)
                    })
                },

            });
        }

        if (selectedProvince != '') {
            triggerCommune();
        }

        function handleDelete(th) {
            var url = $(th).data('href');

            Swal.fire({
                title: "Etes vous sur de vouloir Supprimer la donné?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: `Non, Annuler`,
            }).then((result) => {
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
                title: "Oups, il y a des erreurs",
                html: html,
            });
        }
    </script>

@endsection

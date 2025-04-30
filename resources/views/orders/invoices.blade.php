@extends('app.template')

@section('title','Liste des Factures')

@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Liste des Factures </h2>
                
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Factures</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des Factures</li>
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
                            <h4 class="text-center">Liste des Factures</h4>
                        </div>
                        
                        <form class="col-md-10" action="{{ route('invoices.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div id="custom-search" class="top-search-bar">
                                        <input class="form-control" type="text" placeholder="Search.." name="search" value="{{ old('search',$search) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_date" class="col-form-label">Date Debut</label>
                                        <input class="form-control" type="date" placeholder="Search.." name="start_date" value="{{ old('start_date',$start_date) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="end_date" class="col-form-label">Date Fin</label>
                                        <input class="form-control" type="date" placeholder="Search.." name="end_date" value="{{ old('end_date',$end_date) }}">
                                    </div>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('invoices.index') }}" class="btn btn-light"><i class="fas fa-redo"></i></a>
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
                                        <th scope="col">Code</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Créé Par</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $value)
                                        <tr>
                                            <td>{{ $value->invoice_number }}</td>
                                            <td>{{ $value->customer->customer_firstname .' '.$value->customer->customer_lastname }}</td>
                                            <td>
                                                @if ($value->order_status == 0)
                                                    <span class="badge badge-success">Payer</span>
                                                @else
                                                    <span class="badge badge-danger">Supprimer</span>
                                                @endif
                                            </td>
                                            <td>{{ $value->user->name }}</td>
                                            <td>{{ date('d/m/Y',strtotime($value->date_facturation)) }}</td>
                                            <td>
                                                <a href="{{ route('invoices.show',$value->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
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
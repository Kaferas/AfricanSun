@extends('app.template')

@section('title','Liste des Clients')

@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Liste des Clients </h2>
                <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
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
                <div class="card-header row">
                    <div class="col-md-2 mt-3">
                        <h4 class="text-center">Liste des Clients</h4>
                    </div>
                    
                    <form class="col-md-10" action="{{ route('customer.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="custom-search" class="top-search-bar">
                                    <input class="form-control" type="text" placeholder="Search..">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                <a href="{{ route('customer.index') }}" class="btn btn-light"><i class="fas fa-redo"></i></a>
                            </div>
                            <div class="col-md-2 mt-2">
                                <a href="{{ route('customer.create') }}" class="btn btn-primary">Ajouter</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nom/Prenom</th>
                                    <th scope="col">Province</th>
                                    <th scope="col">Commune</th>
                                    <th scope="col">Telephone</th>
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
                                        <td>
                                            <a href="{{ route('customer.show',$value->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('customer.edit',$value->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('customer.edit',$value->id) }}" class="btn btn-danger btn-sm">
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

@endsection
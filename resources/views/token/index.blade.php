@extends('app.template')

@section('title','Liste des Tokens')

@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Liste des Tokens </h2>
                
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Tokens</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des Tokens</li>
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
                            <h4 class="text-center">Liste des Tokens</h4>
                        </div>
                        
                        <form class="col-md-10" action="{{ route('token.index') }}" method="get">
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
                                    <a href="{{ route('token.index') }}" class="btn btn-light"><i class="fas fa-redo"></i></a>
                                    <a href="{{ route('token.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                                        <th scope="col">Kit</th>
                                        <th scope="col">Token</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Créé Par</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tokens as $value)
                                        <tr>
                                            <td>{{ $value->kit->kit_serial_number }}</td>
                                            <td>{{ $value->generated_token }}</td>
                                            <td>
                                                @if ($value->token_type == 'credit')
                                                    <span class="badge badge-primary">Crédit</span>
                                                @elseif ($value->token_type == 'unlock')
                                                    <span class="badge badge-success">Déverrouillage</span>
                                                @else
                                                    <span class="badge badge-danger">Réinitialisation</span>
                                                @endif
                                            </td>
                                            <td>{{ $value->user->name }}</td>
                                            <td>{{ $value->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('token.show',$value->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                {{-- <a href="{{ route('token.edit',$value->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a> --}}
                                                <a data-href="{{ route('token.destroy',$value->id) }}" onclick="handleDelete(this)" class="btn btn-danger btn-sm">
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
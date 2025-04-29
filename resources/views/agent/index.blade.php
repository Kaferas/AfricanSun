@extends('app.template')
@section('title', 'Agents Listes')

@section("content")
<div class="row">
    <div class="container position-fixed top-0 start-0">
    </div>
    <div class="col-xl-12 col-lg-12 col-md-1 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex col-md-12 justify-content-between">
                    <h3 class="mt-2">Listes des Agents</h3>
                    <div class="row col-md-4 justify-content-end">
                        <a href="{{ route('agents.create') }}" class="btn btn-sm btn-primary mt-2">Nouveau Agent</a>

                        <button class="btn btn-sm btn-success mt-2">Exporter Excel</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered mt-3 text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Adress</th>
                            <th>Province</th>
                            <th>Commune</th>
                            <th>Colline</th>
                            <th>Zone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

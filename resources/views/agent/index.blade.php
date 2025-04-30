@extends('app.template')
@section('title', 'Agents Listes')

@section("content")
    <div class="row mt-3">
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
                            @foreach ($agents as $k => $agent)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{{ $agent->name }}</td>
                                    <td>{{ $agent->email }}</td>
                                    <td>{{ $agent->phone }}</td>
                                    <td>{{ $agent->address }}</td>
                                    <td>{{ $agent->province }}</td>
                                    <td>{{ $agent->commune }}</td>
                                    <td>{{ $agent->colline }}</td>
                                    <td>{{ $agent->zone }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('agents.show', $agent->id) }}" class="btn btn-sm btn-info"><i class="fa fas fa-eye"></i></a>
                                        <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-sm btn-warning"><i class="fa fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fas fa-window-close"></i></button>
                                        </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

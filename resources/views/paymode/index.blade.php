@extends('app.template')
@section('title', 'Modes de Paiement')`
@section("content")
<div class="row">
    <div class="container position-fixed top-0 start-0">
    </div>
    <div class="col-xl-12 col-lg-12 col-md-1 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex col-md-12 justify-content-between">
                    <h3 class="mt-2">Listes Mode Paiements</h3>
                    <div class="row col-md-4 justify-content-end">
                        <a href="{{ route('payMode.create') }}" class="btn btn-sm btn-primary mt-2">Nouveau</a>
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
                            <th>Acount Number</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($payModes as $k => $item)
                                <tr>
                                    <td>{{ ++$k }}</td>
                                    <td>{{ $item->paymode_name }}</td>
                                    <td>{{ $item->paymode_account }}</td>
                                    <td>{{ $item->creator->name }}</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('payMode.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fa fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('payMode.destroy', $item->id) }}" method="POST" class="mt-3 d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fas fa-window-close"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

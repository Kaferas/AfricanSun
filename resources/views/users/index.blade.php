@extends('app.template')
@section('title', 'Listes des Utilisateurs')
@section("content")
    <div class="container">
        <aside class="page-aside">
            <div class="aside-content mt-3">
                <div class="aside-header">
                    <a class="navbar-toggle" data-target=".aside-nav" data-toggle="collapse" type="button"><span class="icon"><i class="fas fa-caret-down"></i></span></a><span class="title">User Management</span>
                </div>
                <div class="aside-compose"><a href="{{ route("users.create") }}" class="btn btn-lg btn-primary btn-block" href="#"><i class="fas fas fa-plus"></i> New User</a></div>
                <div class="aside-nav collapse">
                    <ul class="nav mt-5 fs-1">
                        <li class="@if (request()->routeIs('users.*')) active @endif"><a href="{{ route("users.index") }}"><span class="icon"><i class="fas fa-users"></i></span>Users</a></li>
                        <li class="@if (request()->routeIs('users.profile')) active @endif"><a href="{{ route("users.profile") }}"><span class="icon"><i class="fas fa-child"></i></span>Profile</a></li>
                    </ul>
                </div>
            </div>
        </aside>
        <div class="main-content container mt-3">
            <div class="email-inbox-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="email-title"><span class="icon"><i class="fas fa-list-ul"></i></span> List Users </div>
                    </div>
                    <div class="col-lg-6">
                        <form action="{{ route("users.index") }}"  class="email-search d-flex">
                            @csrf
                            <div class="input-group input-search">
                                <input class="form-control" value="{{ $search }}" name="search" type="text" placeholder="Search User..."><span class="input-group-btn">
                                    <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button></span>
                            </div>
                            <a class="btn btn-sm btn-danger" href="{{ route("users.index") }}"><i class="fas fa-redo"></i></a></span>
                        </form>
                    </div>
                </div>
            </div>
            <div class="email-list card">
                <div class="card-body">
                    <table class="table table-bordered mt-3 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Province</th>
                                <th>Roles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $k => $user)
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? "-" }}</td>
                                    <td>{{ $user->province ??  "-" }}</td>
                                    <td>{{ $user->roles[0]?->name }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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


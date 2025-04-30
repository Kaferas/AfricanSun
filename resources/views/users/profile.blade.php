@extends('app.template')
@section('title', 'Profile Utilisateur')
@section("content")
@php
    $user=auth()->user();
@endphp
<div class="container mt-3">
    <aside class="page-aside">
        <div class="aside-content">
            <div class="aside-header mt-3">
                <a class="navbar-toggle" data-target=".aside-nav" data-toggle="collapse" type="button"><span class="icon"><i class="fas fa-caret-down"></i></span></a><span class="title">User Management</span>
            </div>
            <div class="aside-compose"><button  class="btn btn-lg btn-primary btn-block" href="#"><i class="fas fa-child"></i></span> User Profile</button></div>
            <div class="aside-nav collapse">
                <ul class="nav mt-5 fs-1">
                    <li ><a href="{{ route("users.index") }}"><span class="icon"><i class="fas fa-users"></i></span>Users</a></li>
                    <li class="@if (request()->routeIs('users.profile')) active @endif"><a href="{{ route("users.profile") }}"><span class="icon"><i class="fas fa-child"></i></span>Profile</a></li>
                </ul>
            </div>
        </div>
    </aside>
    <div class="main-content container p-0">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h3 class="mb-2">My Profile </h3>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- ============================================================== -->
            <!-- profile -->
            <!-- ============================================================== -->
            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">
                <!-- ============================================================== -->
                <!-- card profile -->
                <!-- ============================================================== -->
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar text-center d-block">
                            <img src="{{ asset("assets/images/profile.png") }}" alt="User Avatar" class="rounded-circle user-avatar-xxl">
                        </div>
                        <div class="text-center">
                            <h2 class="font-24 mb-0">{{$user->name}}</h2>
                            <p>@ {{ ucfirst($user->roles[0]->name) }}</p>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h3 class="font-16">Contact Information</h3>
                        <div class="">
                            <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-fw fa-envelope mr-2"></i>{{ $user->email }}</li>
                            <li class="mb-0"><i class="fas fa-fw fa-phone mr-2"></i>{{$user->phone}}</li>
                        </ul>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h3 class="font-16">Location:</h3>
                        <div class="">
                            <ul class="mb-0 list-unstyled">
                            <li class="mb-1"><a href="#">Province: <b>{{$user?->province}}</b></a></li>
                            <li class="mb-1"><a href="#">Commune: <b>{{$user?->commune}}</b></a></li>
                            <li class="mb-1"><a href="#">Colline: <b>{{$user?->colline}}</b></li>
                            <li class="mb-1"><a href="#">Zone: <b>{{$user?->zone}}</b></a></li>
                        </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end card profile -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- end profile -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- campaign data -->
            <!-- ============================================================== -->
            <div class="col-xl-9 col-lg-9 col-md-7 col-sm-12 col-12">
                <!-- ============================================================== -->
                <!-- campaign tab one -->
                <!-- ============================================================== -->
                <div class="influence-profile-content pills-regular">
                    <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-campaign-tab" data-toggle="pill" href="#pills-campaign" role="tab" aria-controls="pills-campaign" aria-selected="true">Profile Utilisateur</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-campaign" role="tabpanel" aria-labelledby="pills-campaign-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="section-block">
                                        <h3 class="section-title">My Campaign State</h3>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1">{{$countClient}}</h1>
                                            <p>Clients Enregistre</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="mb-1">35</h1>
                                            <p>Commandes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section-block">
                                <h3 class="section-title">Campaign List</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="media influencer-profile-data d-flex align-items-center p-1">
                                                <div class="mr-4">
                                                    <img src="assets/images/slack.png" alt="User Avatar" class="user-avatar-lg">
                                                </div>
                                                <div class="media-body ">
                                                    <div class="influencer-profile-data">
                                                        <h3 class="m-b-10">Your Campaign Title Here</h3>
                                                        <p>
                                                            <span class="m-r-20 d-inline-block">Draft Due Date
                                                                <span class="m-l-10 text-primary">24 Jan 2018</span>
                                                            </span>
                                                            <span class="m-r-20 d-inline-block"> Publish Date
                                                                <span class="m-l-10 text-secondary">30 Feb 2018</span>
                                                            </span>
                                                                <span class="m-r-20 d-inline-block">Ends <span class="m-l-10  text-info">30 May, 2018</span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top card-footer p-0">
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">45k</h4>
                                        <p>Total Reach</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">29k</h4>
                                        <p>Total Views</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">5k</h4>
                                        <p>Total Click</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">4k</h4>
                                        <p>Engagement</p>
                                    </div>
                                    <div class="campaign-metrics d-xl-inline-block">
                                        <h4 class="mb-0">2k</h4>
                                        <p>Conversion</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end campaign tab one -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- end campaign data -->
            <!-- ============================================================== -->
        </div>
    </div>
</div>
@endsection

@extends('app.template')

@section('title',"Details of Kit $kit->name")

@section('content')

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
    <div class="section-block">
        <h3 class="section-title"> Details of Kit Number: {{$kit->kit_serial_number}}</h3>
        <hr class="text text-info"/>
    </div>
    <div class="tab-vertical-outline">
        <ul class="nav nav-tabs" id="myTab4" role="tablist">
            <li class="nav-item">
                <a class="text-center nav-link active" id="home-outline-verti-tab" data-toggle="tab" href="#home-outline-vertical" role="tab" aria-controls="home" aria-selected="true">KIT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" id="profile-outline-verti-tab" data-toggle="tab" href="#profile-outline-vertical" role="tab" aria-controls="profile" aria-selected="false">Generated Tokens</a>
            </li>
        </ul>
        <div class="tab-content col-12" id="myTabContent4">
            <div class="tab-pane fade show active" id="home-outline-vertical" role="tabpanel" aria-labelledby="home-outline-verti-tab">
                <div class="row">
                    <div class="col-6 mt-3">
                        <p class="lead">Kit Serial Number: {{$kit->kit_serial_number}}</p>
                        <hr class="bg bg-info"/>
                        <img class="border border-info" src="{{ asset("assets/images/wao.png") }}" alt="" widtth="100" height="100">
                    </div>
                    <div class="col-6 mt-3">
                        <p class="lead">Kit Customer Name : <span class="text text-primary">{{$kit->customer->customer_firstname .'-'.$kit->customer->customer_lastname }}</span></p>
                        @php
                            $token_count = sizeof($kit->token);
                        @endphp
                        <p class="lead">Token Counter: {{ $token_count }}</p>
                        <p class="lead">Latest Activity : {{ $token_count > 0 ? $kit->token[$token_count -1 ]->token_type : '' }}</p>
                        <p class="lead">Latest Date : {{ $token_count > 0 ? $kit->token[$token_count -1]->created_at->format('d/m/Y') : '' }}</p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="profile-outline-vertical" role="tabpanel" aria-labelledby="profile-outline-verti-tab">
                {{-- <h3>Outline Vertical tabs</h3> --}}
                        <h4 class="card-header">Historique des Tokens </h4>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Token</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Expired</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kit->token as $value)
                                        <tr>
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
                                            <td>{{ $value->end_token_date }}</td>
                                            <td>{{ $value->user->name }}</td>
                                            <td>{{ $value->created_at->format('d/m/Y') }}</td>
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

@extends('app.template')
@section('title', 'Creer un  Mode Paiement')
@section("content")

<div class="row mt-3">
    <div class="container position-fixed top-0 start-0 ">
    </div>
    <div class="col-xl-12 col-lg-12 col-md-1 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="mt-2">Creer Mode Paiement</h3>
            </div>
            <div class="card-body">
                <form class="p-3" action="{{ route('payMode.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row form-group">
                        <label for="">Mode Paiement</label>
                        <input type="text" name="paymode_name" value="{{ old('paymode_name') }}" class="form-control mb-3" placeholder="Nom du mode de paiement" >
                        @error('paymode_name')
                            <div class="text-white text-center bg bg-danger col-12 p-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <label for="">Numero de Compte</label>
                        <input type="text" name="paymode_account" class="form-control mb-3" value="{{ old('paymode_account') }}" placeholder="Numero de compte" >
                        @error('paymode_account')
                            <div class="text-white text-center bg bg-danger col-12 p-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_content')
@endsection

@extends('app.template')

@section('title',isset($customer) ? "Modification d'un client" : "Ajout d'un client" )

@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header"><h2>Formulaire Client</h2></div>
                <div class="card-body">
                    <form action="{{ isset($customer) ? route('customer.update', $customer->id) : route('customer.store') }}" method="POST">
                        @csrf
                        @if(isset($customer))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="customer_firstname">Nom</label>
                                    <input type="text" class="form-control @error('customer_firstname') is-invalid @enderror" id="customer_firstname" name="customer_firstname" value="{{ old('customer_firstname', $customer->customer_firstname ?? '') }}" >
                                    @error('customer_firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="customer_lastname">Prénom</label>
                                    <input type="text" class="form-control @error('customer_lastname') is-invalid @enderror" id="customer_lastname" name="customer_lastname" value="{{ old('customer_lastname', $customer->customer_lastname ?? '') }}" >
                                    @error('customer_lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="customer_cni">CNI</label>
                                    <input type="text" class="form-control @error('customer_cni') is-invalid @enderror" id="customer_cni" name="customer_cni" value="{{ old('customer_cni', $customer->customer_cni ?? '') }}" >
                                    @error('customer_cni')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="customer_phone">Téléphone</label>
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $customer->customer_phone ?? '') }}" >
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="customer_province">Province</label>
                                    <select id="province" name="customer_province" onchange="triggerCommune()"
                                        class="select2 form-control @error('customer_province') is-invalid @enderror"
                                        >
                                        <option>Sélectionnez une province</option>
                                        @foreach ($provinces as $value)
                                            <option value="{{ $value->region }}"
                                                {{ old('customer_province', $customer->customer_province ?? '') == $value->region ? 'selected' : '' }}>
                                                {{ $value->region }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group externeC" {{ isset($customer) ? '' : 'hidden' }}>
                                    <label for="customer_commune">Commune</label>
                                    <select id="commune" name="customer_commune" onchange="triggerQuartier()"
                                        class="select2 form-control @error('customer_commune') is-invalid @enderror"
                                        >
                                        @if(isset($customer))
                                            <option value="{{ $customer->customer_commune }}" selected>{{ $customer->customer_commune }}</option>
                                        @endif
                                    </select>
                                    @error('customer_commune')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group externeZ" {{ isset($customer) ? '' : 'hidden' }}>
                                    <label for="customer_zone">Zone</label>
                                    <select id="zone" name="customer_zone" onchange="triggerColline()"
                                        class="select2 form-control @error('customer_zone') is-invalid @enderror"
                                        >
                                        @if(isset($customer))
                                            <option value="{{ $customer->customer_zone }}" selected>{{ $customer->customer_zone }}</option>
                                        @endif
                                    </select>
                                    @error('customer_zone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group externeQ" {{ isset($customer) ? '' : 'hidden' }}>
                                    <label for="customer_colline">Colline</label>
                                    <input type="text" class="form-control @error('customer_colline') is-invalid @enderror" id="customer_colline" name="customer_colline" value="{{ old('customer_colline', $customer->customer_colline ?? '') }}">
                                    @error('customer_colline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if(isset($customer))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                triggerCommune();
                                setTimeout(() => {
                                    triggerQuartier();
                                    triggerColline();
                                }, 500);
                            });
                        </script>
                        @endif

                        <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();" {{ $errors->any() ? 'enabled' : '' }}>{{ isset($customer) ? 'Modifier' : 'Ajouter' }}</button>

                        @if ($errors->any())
                            <script>
                                document.querySelector('button[type="submit"]').disabled = false;
                            </script>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_content')


<script>
    function triggerCommune() {
        let province = $("#province").val()
        // $(".externeQ").attr("hidden", true)
        $.ajax({
            url: "{{ url('communeOfProvince') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                province: province
            },
            success: function(data) {
                $("#commune").find('option').remove().end();
                $(".externeC").attr("hidden", false);
                $.each(data, function(key, value) {
                    $("#commune").append(
                        `<option class="" value='${value.district}'>${value.district}</option>`)
                })
            },

        });
    }

    function triggerQuartier() {
        let commune = $("#commune").find(":selected").val()
        $.ajax({
            url: "{{ url('quartierOfCommune') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                commune: commune
            },
            success: function(data) {
                $("#zone").find('option').remove().end();
                if (data.length > 0) {
                    $(".externeZ").attr("hidden", false);
                    $.each(data, function(key, value) {
                        $("#zone").append(
                            `<option value='${value.city}'>${value.city}</option>`)
                    })
                }
            },
        });
    }

    function triggerColline() {
        $(".externeQ").attr("hidden", false);
    }
</script>

@endsection
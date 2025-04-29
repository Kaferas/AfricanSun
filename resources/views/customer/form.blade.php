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
                        @if(isset($client))
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="customer_firstname">Nom</label>
                            <input type="text" class="form-control @error('customer_firstname') is-invalid @enderror" id="customer_firstname" name="customer_firstname" value="{{ old('customer_firstname', $customer->customer_firstname ?? '') }}" required>
                            @error('customer_firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_lastname">Prénom</label>
                            <input type="text" class="form-control @error('customer_lastname') is-invalid @enderror" id="customer_lastname" name="customer_lastname" value="{{ old('customer_lastname', $customer->customer_lastname ?? '') }}" required>
                            @error('customer_lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_cni">CNI</label>
                            <input type="text" class="form-control @error('customer_cni') is-invalid @enderror" id="customer_cni" name="customer_cni" value="{{ old('customer_cni', $customer->customer_cni ?? '') }}" required>
                            @error('customer_cni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_phone">Téléphone</label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $customer->customer_phone ?? '') }}" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_province">Province</label>
                            <select id="customer_province" name="customer_province"
                                class="select2 form-control @error('customer_province') is-invalid @enderror"
                                required>
                                <option>Sélectionnez un membre</option>
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
                        <div class="form-group">
                            <label for="customer_commune">Commune</label>
                            <select id="customer_commune" name="customer_commune"
                                class="select2 form-control @error('customer_commune') is-invalid @enderror"
                                required>
                            </select>
                            
                            @error('customer_commune')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_zone">Zone</label>
                            <input type="text" class="form-control @error('customer_zone') is-invalid @enderror" id="customer_zone" name="customer_zone" value="{{ old('customer_zone', $customer->customer_zone ?? '') }}" required>
                            @error('customer_zone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_colline">Colline</label>
                            <input type="text" class="form-control @error('customer_colline') is-invalid @enderror" id="customer_colline" name="customer_colline" value="{{ old('customer_colline', $customer->customer_colline ?? '') }}" required>
                            @error('customer_colline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_section')


<script>
    function triggerCommune() {
        let province = $("#province").val()
        $(".externeC").attr("hidden", false)
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
                $("#colline_cooperative").find('option').remove().end();
                if (data.length > 0) {
                    $(".externeQ").attr("hidden", false)
                    $.each(data, function(key, value) {
                        $("#colline_cooperative").append(
                            `<option value='${value.city}'>${value.city}</option>`)
                    })
                }
            },
        });
    }
</script>

@endsection
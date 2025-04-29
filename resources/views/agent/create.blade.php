@extends('app.template')
@section('title', 'Creer un Agent')
@section("content")

<div class="row mt-3">
    <div class="container position-fixed top-0 start-0">
    </div>
    <div class="col-xl-12 col-lg-12 col-md-1 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="mt-2">Creer un Agent</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('agents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between mt-3">
                        <input type="text" name="name" class="form-control mb-3" placeholder="Nom et Prenom" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="text" name="phone" class="form-control mb-3" placeholder="Telephone" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr class="text text-default"/>
                    <div class="d-flex justify-content-between mt-3">
                        <select name="province" id="province" class="form-control" onchange="triggerCommune()"
                            <option  selected>Selectionner province</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->region }}">{{ $province->region }}</option>
                            @endforeach
                        </select>
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <select name="commune" id="commune" class="externeC form-control" hidden onchange="triggerQuartier()">
                            <option value="">Commune</option>
                        </select>
                        @error('commune')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <select name="colline" id="colline" class="externeQ form-control" hidden onchange="disableZoneField()">
                            <option value="">Colline</option>
                        </select>
                        @error('colline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr class="text text-default"/>
                    <div class="d-flex justify-content-between mt-3">
                        <input type="text" name="zone" class="zone form-control mb-3" placeholder="Zone" required hidden>
                        @error('zone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                        <input type="text" name="address" class="form-control mb-3" placeholder="Adresse" required>
                        @error('address')
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
@section('js_content')
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
                $("#colline").find('option').remove().end();
                if (data.length > 0) {
                    $(".externeQ").attr("hidden", false)
                    $.each(data, function(key, value) {
                        $("#colline").append(
                            `<option value='${value.city}'>${value.city}</option>`)
                    })
                }
            },
        });
    }

    function disableZoneField() {
        let colline = $("#colline").find(":selected").val()
        if (colline != "") {
            $(".zone").attr("hidden", false)
            $("input[name='zone']").attr("hidden", false)
        } else {
            $(".zone").attr("hidden", true)
            $("input[name='zone']").attr("hidden", true)
        }
    }
</script>
@endsection

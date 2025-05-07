@extends('app.template')
@section('title', 'Modifier Utilisateur')
@section('content')

<div class="row">
    <div class="container position-fixed top-0 start-0">
    </div>
    <div class="col-xl-12 col-lg-12 col-md-1 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="mt-2 text text-primary">Modifier Utilisateur</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update',$user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3" hidden>
                        <label for="">Selectionner Agent</label>
                        <select class="form-select form-control" id="agent_id" name="agent_id" required>
                            <option value="" disabled selected>Choisir un agent</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select form-control" id="role" name="role" required>
                            <option value="" disabled selected>Choisir un role</option>
                            @foreach ($roles as $role)
                                <option {{ $role->id == $role_user ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <hr class="text text-default"/>
                    <div class="d-flex justify-content-between mt-4 mb-3">
                        <select name="province" id="province" class="form-control" onchange="triggerCommune()">
                            <option  selected>Selectionner Province</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->region }}">{{ $province->region }}</option>
                            @endforeach
                        </select>
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <select name="commune" id="commune" class="externeC form-control"  onchange="triggerQuartier()">
                            <option value="">Commune</option>
                        </select>
                        @error('commune')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <select name="colline" id="colline" class="externeQ form-control"  onchange="disableZoneField()">
                            <option value="">Colline</option>
                        </select>
                        @error('colline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="text" name="zone" id="zone" class="zone form-control mb-3" placeholder="Zone" required >
                        @error('zone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
                    <hr class="text text-default"/>
                    <div class="d-flex">
                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-around">
                        <div class="mb-3 col-md-6">
                            <label for="">Password:</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="">Retype Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    <div class="d-flex mt-4">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                        <a href="{{ route('users.index') }}" class="btn btn-warning text-white">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_content')
<script>
    var selectedAgent= "{{ $selectAgent }}";

    window.onload = function() {
        if (selectedAgent != 0) {
            $("#agent_id").val(selectedAgent);
            fillUpFields();
        }
    };

    const fillUpFields=()=>{
        let agent_id = $("#agent_id").val()
        if (agent_id == "") {
            $("#name").val("")
            $("#email").val("")
            $("#phone").val("")
            $("#address").val("")
            return
        }else{
            $.ajax({
            url: "{{ url('getAgent') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                agent_id: selectedAgent
            },
            success: function(data) {
                $("#name").val(data.name)
                $("#email").val(data.email)
                $("#phone").val(data.phone)
                $("#address").val(data.address)
                $("#province").val(data.province).trigger('change')
                triggerCommune();
                let commune=data.commune;
                triggerQuartier(commune);
                let colline=data.colline;
                disableZoneField(colline);
                $("#zone").val(data.zone);
            },
        });
        }
    }

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
                $("#commune").append(
                    `<option class="" value=''>Selectionner commune</option>`);
                $.each(data, function(key, value) {
                    $("#commune").append(
                        `<option class="" value='${value.district}'>${value.district}</option>`)
                })
            },

        });
    }

    function triggerQuartier(co) {
        let commune = co == undefined ? $("#commune").find(":selected").val() : co
        $.ajax({
            url: "{{ url('quartierOfCommune') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                commune: commune
            },
            success: function(data) {
                $("#colline").find('option').remove().end();
                $("#colline").append(
                    `<option class="" value=''>Selectionner colline</option>`);
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

    function disableZoneField(col) {
        let colline = col == undefined ? $("#colline").find(":selected").val() : col;
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

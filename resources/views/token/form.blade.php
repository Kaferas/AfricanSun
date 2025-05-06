@extends('app.template')

@section('title',isset($token) ? 'Modifier un Token' : 'Ajouter un Token')

@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">{{ isset($token) ? 'Modifier un Token' : 'Ajouter un Token' }}</div>

            <div class="card-body">
                <form method="POST" id="token_form" action="{{ isset($token) ? route('token.update', $token->id) : route('token.store') }}">
                    @csrf
                    @if(isset($token))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kit_id">Kit</label>
                                <select id="kit_id" name="kit_id"
                                    class="select2 form-control @error('kit_id') is-invalid @enderror">
                                    <option selected disabled>Sélectionnez un kit</option>
                                    @foreach ($kits as $value)
                                        <option value="{{ $value->id }}"  {{ old('kit_id', $token->kit_id ?? '') == $value->id ? 'selected' : '' }}>
                                            {{ $value->kit_serial_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="token_type">Type de token</label>
                                <select id="token_type" name="token_type" onchange="displayDateField(this)"
                                    class="select2 form-control @error('token_type') is-invalid @enderror">
                                    <option selected disabled>Sélectionnez un type</option>
                                    <option value='credit' {{ old('token_type', $token->token_type ?? '') == 'credit' ? 'selected' : '' }}>Crédit</option>
                                    <option value='unlock' {{ old('token_type', $token->token_type ?? '') == 'unlock' ? 'selected' : '' }}>Déverrouillage</option>
                                    <option value='reset' {{ old('token_type', $token->token_type ?? '') == 'reset' ? 'selected' : '' }}>Réinitialisation</option>
                                    
                                </select>
                                @error('token_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3" id="dateField" hidden>
                                <label for="end_token_date" class="col-md-4 col-form-label text-md-right">Date Fin</label>
                                <div class="col-md-6">
                                    <input id="end_token_date" type="date" class="form-control @error('end_token_date') is-invalid @enderror" 
                                        name="end_token_date" value="{{ old('end_token_date', isset($token) ? $token->end_token_date : '') }}" >
                                    @error('end_token_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3" id="tokenField" hidden>
                                <label for="generated_token" class="col-md-4 col-form-label text-md-right">Generated Token</label>
                                <div class="col-md-6">
                                    <input type="text" name="generated_token" id="generated_token" class="form-control @error('generated_token') is-invalid @enderror"
                                    value="{{ old('generated_token', isset($token) ? $token->generated_token : '') }}">

                                    @error('generated_token')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                    </div>



                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" id="saveBtn" class="btn btn-primary">
                                Generer
                            </button>
                            <a href="{{ route('token.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js_content')
    <script>

        var kits = <?=json_encode($kits) ?>;
        
        function displayDateField(th) {
            var type = $(th).val();

            if (type == 'credit') {
                $('#dateField').attr('hidden',false);
            } else {
                $('#dateField').attr('hidden',true);
            }
        }

        function calculateDaysBetween(date) {
            const today = new Date();
            const givenDate = new Date(date);
            const diffTime = Math.abs(givenDate - today);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Added +1 to include both start and end dates
            return diffDays;
        }

        function getSerialNumber(id) {
            var kit = kits.filter((row) => row.id == id);
            
            if (kit.length == 1) {
                return [kit[0].kit_serial_number,kit[0].token_count];
            } else {
                return [];
            }
        }

        $(document).ready(function() {
            $('#saveBtn').on('click', async  function(e) {
                e.preventDefault(); // Prevent the default form submission
                $("#saveBtn").attr('disabled',true);
                var url = "{{ route('get.token') }}";

                var type =$('#token_type').val();
                var endDate =$('#end_token_date').val();
                var command = type == 'credit' ? 1 : (type == 'unlock' ? 3 : 5);
                var data = command == 1 ? calculateDaysBetween(endDate) : 0;
                
                var kitId = $('#kit_id').val();
                var kitData = getSerialNumber(kitId);
                var resultcount = kitData[1] == 0 ? 0 : (parseInt(kitData[1]) + 1); 

                var formData = {
                    'command': command,
                    'data': data,
                    'count': (3 + resultcount),
                    'key': kitData[0]
                }

                

                $.ajax({
                    url: url, // Replace with your route name
                    type: 'POST',
                    data: {
                        data: JSON.stringify(formData),
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        
                        data = typeof data == 'string' ? JSON.parse(data) : data;
                        
                        if(data.token) {
                            $('#generated_token').val(data.token);
                            $('#tokenField').attr('hidden',false);
                            $('#token_form').trigger('submit');
                        } else {
                            //handle fixing issues

                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error(xhr.responseText);
                    }
                });
            });
        });

    </script>
@endsection
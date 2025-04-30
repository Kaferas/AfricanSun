@extends('app.template')

@section('title','Formulaire de Commande')

@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header"><h2>Formulaire Commande</h2></div>
                <div class="card-body">
                    <form id="order_form" action="{{ isset($orders) ? route('orders.update', $orders->id) : route('orders.store') }}" method="POST">
                        @csrf
                        @if(isset($orders))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="customer_id">Client</label>
                                    <select id="customer_id" name="customer_id"
                                        class="select2 form-control @error('customer_id') is-invalid @enderror"
                                        >
                                        <option selected disabled>Sélectionnez un client</option>
                                        @foreach ($customers as $value)
                                            <option value="{{ $value->id }}"
                                                {{ old('customer_id', $orders->customer_id ?? '') == $value->id ? 'selected' : '' }}>
                                                {{ $value->customer_firstname .' '.$value->customer_lastname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mt-2">
                                    <a href="#" onclick="handleOpenModal(this)" class="btn btn-primary">Ajouter un Service</a>  
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Service</th>
                                                <th scope="col">Prix</th>
                                                <th scope="col">Qte</th>
                                                {{-- <th scope="col">Total</th> --}}
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="order_items">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <button type="submit" id="saveBtn" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-labelledby="modalMetropoleLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appModalFromLabel">Liste des Services</h5>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Service</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="services_list">
                                    @foreach ($services as $value)
                                        <tr id="service_{{ $value->id }}">
                                            <td>{{ $value->service_name }}</td>
                                            <td>{{ $value->service_price }}</td>
                                            <td><a href="#" onclick="handleAddService(this)" data-id="{{ $value->id }}" data-name="{{ $value->service_name }}" data-price="{{ $value->service_price }}" class="btn btn-primary">Ajouter</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js_content')

<script>
    var allServices = <?=json_encode($services) ?>;
    var ordersDetails = <?=json_encode($orderDetails) ?>;
    var chosedServices = [];

    function handleOpenModal(th) {
        $('#appFormModal').modal('show');
    }

    if (ordersDetails.length > 0) {
        var _html = "";
        ordersDetails.forEach(row => {
            _html = `
            <tr id="order_service_${row.service_id}">
                <td>
                    ${row.service_name}
                    <input type="hidden" name="service_name[]" value="${row.service_name}">
                    <input type="hidden" name="service_id[]" value="${row.service_id}">
                </td>
                <td>
                    <input type="hidden" name="service_price[]" value="${row.service_price}">
                    <input type="number" name="sold_price[]" class="form-control" value="${row.sold_price}">
                </td>
                <td>
                    <input type="number" name="sold_qty[]" class="form-control" value="${row.sold_qty}">
                </td>
                <td><a href="#" onclick="removeService(this)" data-id="${row.service_id}" class="btn btn-danger btn-sm">x</a></td>
            </tr>
            `;
            chosedServices.push(row.service_id);
        });
        $('#order_items').append(_html);    
    }

    function handleAddService(th) {
        var serviceId=$(th).data('id');
        var serviceName=$(th).data('name');
        var servicePrice=$(th).data('price');

        if (chosedServices.includes(serviceId)) {
            Swal.fire({
                icon: 'error',
                title: "Ce service a déjà été ajouté.",
            });
            return;
        }
        var html = `
        <tr id="order_service_${serviceId}">
            <td>
                ${serviceName}
                <input type="hidden" name="service_name[]" value="${serviceName}">
                <input type="hidden" name="service_id[]" value="${serviceId}">
            </td>
            <td>
                <input type="hidden" name="service_price[]" value="${servicePrice}">
                <input type="number" name="sold_price[]" class="form-control" value="${servicePrice}">
            </td>
            <td>
                <input type="number" name="sold_qty[]" class="form-control" value="1">
            </td>
            <td><a href="#" onclick="removeService(this)" data-id="${serviceId}" class="btn btn-danger btn-sm">x</a></td>
        </tr>
        `;
        chosedServices.push(serviceId);
        $('#order_items').append(html);
    }

    function removeService(th) {
        var id = $(th).data('id');
        $(`#order_service_${id}`).remove();
        chosedServices = chosedServices.filter((row) => row != id);
        
    }

    $(document).ready(function() {
        $('#order_form').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            $("#saveBtn").attr('disabled',true);
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'), // Replace with your route name
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    data = typeof data == 'string' ? JSON.parse(data) : data;
                    
                    if(data.success) {
                   
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.messages,
                            showConfirmButton: false,
                            timer: 5000
                        });
                        window.location.href = "{{ route('orders.index') }}";
                    } else {
                        var errors = Object.values(data.messages);
                        var list_error_html = `<ul class="list-group">`;

                        errors.forEach(element => {
                            list_error_html += `
                            <li class="list-group-item text-danger">${element}</li>
                            `;
                        });

                        list_error_html += '</ul>';
                        Swal.fire({
                            icon: 'error',
                            title: "Oups,il y a des erreurs",
                            html: list_error_html,
                        });
                        $("#saveBtn").attr('disabled',false);
                        $('#infos').attr('hidden',true);
                        // console.log(Object.values(data.messages));

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
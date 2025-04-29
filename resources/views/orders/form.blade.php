@extends('app.template')

@section('title','Formulaire de Commande')

@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header"><h2>Formulaire Commande</h2></div>
            <div class="card-body">
                <form action="{{ isset($orders) ? route('orders.update', $orders->id) : route('orders.store') }}" method="POST">
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
                                    <option>Sélectionnez un client</option>
                                    @foreach ($customers as $value)
                                        <option value="{{ $value->region }}"
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
    var chosedServices = [];

    function handleOpenModal(th) {
        $('#appFormModal').modal('show');
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
            <td><a href="#" onclick="removeService(this)" data-id="{{ $value->id }}" class="btn btn-danger btn-sm">x</a></td>
        </tr>
        `;
        chosedServices.push(serviceId);
        $('#order_items').append(html);
    }
</script>

@endsection
@extends('app.template')

@section('title','Detail de la commande')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header"><h2>Formulaire Commande</h2></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h3>Commande</h3>
                        <p class="mb-0">Numero: {{ $orders->order_code }}</p>
                        <p class="mb-0">Date: {{ $orders->created_at->format('d/m/Y') }}</p>
                        <br>

                        <h5>Client</h5>
                        <p>Nom/Prenom: {{ $orders->customer->customer_firstname .' '.$orders->customer->customer_lastname }}</p>
                        <p>Addresse:{{ $orders->customer->customer_province .'/'.$orders->customer->customer_commune.'/'.$orders->customer->customer_zone.'/'.$orders->customer->customer_colline }} </p>
                        <p>Phone: {{ $orders->customer->customer_phone }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <a href="#" onclick="handleOpenModal(this)" class="btn btn-success">Valider le payaiement</a>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th>Quantite</th>
                                    <th>Prix</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $subTot = 0;
                                @endphp
                                @foreach ($ordersDetails as $value)
                                    @php
                                        $subTot = $value->sold_price * $value->sold_qty;
                                        $total += $subTot;
                                    @endphp
                                    <tr>
                                        <td>{{ $value->service_name }}</td>
                                        <td>{{ $value->sold_qty }}</td>
                                        <td>{{ $value->sold_price }}</td>
                                        <td>{{ $subTot }}</td>
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                            <tfoot>
                                {{-- <tr>
                                    <th colspan="3" class="text-end">Subtotal</th>
                                    <td>$820.00</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Tax (10%)</th>
                                    <td>$82.00</td>
                                </tr> --}}
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <td ><strong id="total"> {{ $total }} </strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
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
                    <h5 class="modal-title" id="appModalFromLabel"></h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('order.pay') }}" method="POST" id="modalForm">
                        @csrf
                        <div class="form-group">
                            <label for="mode">Mode de Paiement</label>
                            <select id="mode" name="mode"
                                class="select2 form-control @error('customer_id') is-invalid @enderror"
                                >
                                <option selected disabled>Sélectionnez un client</option>
                                @foreach ($mode as $value)
                                    <option value="{{ $value->id }}">
                                        {{ $value->paymode_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Prix</label>
                            <input type="number" name="price" id="price" class="form-control">
                            <input type="hidden" name="order" id="order" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary" onclick="handleSaveData(this)">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js_content')

<script>

    var order = <?= json_encode($orders) ?>;

    function handleOpenModal(th) {
        var price = parseFloat($('#total').html());
        
        $('#price').val(price);
        $('#order').val(order.order_code);
        $('#appFormModal').modal('show');
    }

    function handleSaveData(th) {
        $(th).prop('disabled', true);
        var form_data = $('#modalForm');

        $.ajax({
            url: form_data.attr('action'),
            method: form_data.attr('method'),
            data: form_data.serialize(),
            success: function(response) {
                response = typeof response == 'string' ? JSON.parse(response) : response;
                if (response.success) {
                    $('#appFormModal').modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.messages,
                        showConfirmButton: false,
                        timer: 5000
                    });
                    window.location.reload();
                } else {
                    handleErrors(response);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                handleErrors(xhr.responseJSON);
            },
            complete: function() {
                $(th).prop('disabled', false);
            }
        });
    }

    function handleErrors(data) {
        var errors = Object.values(data.messages);
        var html = "<ul class='list-group'>";
        errors.forEach(element => {
            html += `<li class="list-group-item text-danger">${element}</li>`;
        });
        html += "</ul>";
        Swal.fire({
            icon: 'error',
            title: "Oups,il y a des erreurs",
            html: html,
        });

    }
</script>

@endsection
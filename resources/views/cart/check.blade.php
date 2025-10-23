@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>{{ __('Checkout') }}</h4></div>
                <div class="card-body">
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Img</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col" class="text-end">Price</th>
                                <th scope="col" class="text-end">Quantity</th>
                                <th scope="col" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $key => $product)
                                    @php $total += $product['quantity'] * $product['price']; @endphp
                                    <tr data-id="{{$key}}">
                                        <td>
                                            <img src="/products/{{$product['image']}}" alt="" width="40">
                                            
                                        </td>
                                        <td><h4>{{$product['name']}}</h4></td>
                                        <td><h4>{{$product['description']}}</h4></td>
                                        <td class="text-end">${{$product['price']}}</td>
                                        <td class="text-end">{{$product['quantity']}}</td>
                                        <td class="text-end">${{$product['quantity'] * $product['price']}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5"></td>
                                    <td class="text-end">${{$total}}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                <div class="card-footer text-center" id="paypal-button-container">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="https://www.paypal.com/sdk/js?client-id={{env("PAYPAL_CLIENT_ID")}}&components=buttons"></script>
<script>
     paypal.Buttons({
            style: {
                layout: 'vertical',
                color:  'blue',
                shape:  'rect',
                label:  'paypal',
                disableMaxWidth: true,
            },
            createOrder: function() {
                return fetch('/paypal/create-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(data) {
                    return data.id;  // Order ID
                });
            },
            onApprove: function(data) {
                return fetch(`/paypal/capture-order/${data.orderID}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(details) {
                    console.log('Transacción completada por ' + details.payer.name.given_name);
                    console.log(details)

                    Swal.fire({
                        icon: "info",
                        title: "Payment Completed",
                    }).then((result) => {
                        window.location.href = "/home";
                    });
                    

                    // Redirigir o mostrar mensaje de éxito
                });
            },
            onError: function (err) {
                console.error('Error en el pago:', err);
                alert('Ocurrió un error durante el pago');
            }
        }).render('#paypal-button-container');
</script>
@endsection
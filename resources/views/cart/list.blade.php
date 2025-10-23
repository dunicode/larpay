@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="cart-products">
        @include('cart.box')
    </div>
    <div class="text-end">
        <a href="{{route('product.list')}}" class="btn btn-warning">Continue Shopping</a>
        @if(session('cart'))
            <a href="{{ route("cart.check") }}" class="btn btn-success">Checkout</a>
        @endif
    </div>
</div>
@endsection

@section('footer')
<script type="module">
    $("body").on("change", ".quantity", function(e){
        let element = $(this);

        $.ajax({
            url: "{{route('cart.update')}}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: "update",
                product_id: element.parents("tr").attr("data-id"),
                quantity: element.val()
            },
            success: function(response){
                $("#cart-products").html(response.success);
            }
        })
    });

    $("body").on("click", ".remove-from-cart", function(e){
        let element = $(this);

        $.ajax({
            url: "{{route('cart.update')}}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: "delete",
                product_id: element.parents("tr").attr("data-id"),
                quantity: element.val()
            },
            success: function(response){
                $("#cart-products").html(response.success);
            }
        })
    });
</script>
@endsection
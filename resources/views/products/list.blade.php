@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>
                <div class="card-body">
                    @session("success")
                        <div class="alert alert-success">{{$value}} <a href="{{route('cart.list')}}" class="alert-link">View Cart</a></div>
                    @endsession
                    <div class="row">
                        @foreach ($data as $item)
                            <div class="col-4">
                                <div class="card">
                                    <img src="/products/{{$item->image}}" class="card-image p-2">
                                    <div class="card-body text-center">
                                        <h4>{{$item->name}}</h4>
                                        <p>{{$item->description}}</p>
                                        <p><strong>${{$item->price}}</strong></p>
                                        <a href="{{route('cart.add', $item->id)}}" class="btn btn-warning">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

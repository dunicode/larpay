@if(session('cart'))
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="30">Actions</th>
                <th width="50">Product</th>
                <th width="60%">Name</th>
                <th width="100" class="text-end">Price</th>
                <th class="text-end" width="100">Quantity</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach(session('cart') as $key => $product)
                @php $total += $product['quantity'] * $product['price']; @endphp
                <tr data-id="{{$key}}">
                    <td>
                        <a class="btn btn-sm btn-danger remove-from-cart"><i class="fa fa-trash"></i></a>
                    </td>
                    <td>
                        <img src="/products/{{$product['image']}}" alt="" width="40">
                        
                    </td>
                    <td><h4>{{$product['name']}}</h4></td>
                    <td class="text-end">${{$product['price']}}</td>
                    <td class="text-end"><input type="number" name="quantity" class="form-control quantity" value="{{$product['quantity']}}" min="1"></td>
                    <td class="text-end">${{$product['quantity'] * $product['price']}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5"></td>
                <td class="text-end"><h4>${{$total}}</h4></td>
            </tr>
        </tbody>
    </table>
@endif
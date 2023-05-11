@extends('shop')

@section('content')
<table id="cart" class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
        @foreach(session('cart') as $id => $details)
        <?php $total += $details['price'] * $details['quantity'] ?>
        <tr rowId="{{ $id }}">
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" class="card-img-top" /></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                    </div>
                </div>
            </td>
            <td data-th="Price">${{ $details['price'] }}</td>
            <td class="justify-center mt-6 md:justify-end md:flex">
                <div class="h-10 w-28">
                    <div class="relative flex flex-row w-full h-8">

                        <form action="{{ route('update.sopping.cart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id}}">
                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="w-6 text-center bg-gray-300" />
                            <button type="submit" class="btn btn-primary" class="px-2 pb-2 ml-2 text-white bg-blue-500">update</button>
                        </form>
                    </div>
                </div>
            </td>
            <td data-th="Subtotal" class="text-center">{{$details['price'] * $details['quantity']}}</td>
            <td class="actions">

                <form action="{{ route('delete.cart.product') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$id}}" name="id">
                    <button type="submit" class="btn btn-danger" class="px-2 pb-2 ml-2 text-white bg-blue-500">delete</button>
                </form>

            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right">
                <a href="{{ url('/dashboard') }}" class="btn btn-primary"><i class="fa fa-angle-left"></i> Continue Shopping</a>
            </td>

            <td colspan="3" class="text-right">
                <div>
                    <h5> Sub Total: ${{$total}}</h5>
                    <!-- <h5> Discount: ${{$discount}}</h5> -->
                    <h5> Total: ${{$discount}}</h5>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
@endsection

@section('scripts')

@endsection
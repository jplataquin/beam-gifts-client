@extends('layouts.app')

@section('content')

<div class="container">
    <h1>{{ $item->name }}</h1>
    <div class="row mb-3">
        <div class="col">
            <img class="img" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$item->photo['400px']}}"/>
        </div>
        <div class="col">
            <h5>Php {{$item->price}}</h5>
            <ul>
                <li>Expires in {{$item->expiry}} days after purchase</li>
                <li>Can be sent via link</li>
            </ul> 
            <div class="form-group mb-3">
                <label>Quantity per Gift</label>
                <select class="form-control" id="qty">
                    @for ($i = 1; $i<=5; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select> 
            </div>
            <div>
                <button id="buyNowBtn" class="btn btn-block btn-warning me-2">Buy Now</button>
                <button id="addToCartBtn" class="btn btn-block btn-primary">Add To Cart</button>
            </div>        
        </div>
    </div>
</div>
<script type="module">
    const addToCartBtn  = document.querySelector('#addToCartBtn');
    const buyNowBtn     = document.querySelector('#buyNowBtn');
    const qty           = document.querySelector('#qty');

    addToCartBtn.onclick = (e)=>{
        e.preventDefault();

        addToCartBtn.disabled = true;
        buyNowBtn.disabled = true;

        window.util.addToCart({
            id:'{{$item->id}}',
            qty: qty.value
        }).then(reply=>{

            addToCartBtn.disabled = false;
            buyNowBtn.disabled = false;

            if(reply.status <= 0){
                alert(reply.message);
                return;
            }

            alert('Item in cart');

        });
    }
</script>
@endsection

@extends('layouts.app')

@section('content')

    <div class="container">

        @foreach($items as $item)
            <div class="border border-primary mb-3 p-2">
                <div class="row">
                    <div class="col-12 bg-darkmagenta">
                        <h3 class="fontcolor-white">{{$item->name}}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 mb-3">
                        <img class="img" src="{{config('app')['api_base_url']}}storage/photos/item/150px/{{$item->attributes['image']}}"/>
                    </div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-7">
                                
                                <div>
                                    Qty: {{$item->quantity}}
                                </div>
                                <div>
                                    Price: {{number_format($item->price,2)}}
                                </div>
                            </div>
                            <div class="col-5 text-end">
                                <h3>PHP {{number_format($item->quantity * $item->price,2)}}</h3>
                                <button data-id="{{$item->id}}" class="removeBtn btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
        <div class="col">
            <div class="form-group">
                <label>Payment Method</label>
                <div>
                    <label class="me-3">
                        <input type="radio" class="" name="paymentMethod" value="cc" checked/> Credit Card
                    </label>
                    </label class="me-3">
                        <input type="radio" class="" name="paymentMethod" value="gc"/> Gcash
                    </label>
                </div>
            </div>
        </div>
        <div class="col text-end">
            <h2>PHP {{number_format($total,2)}}</h2>
            <button id="checkout" class="btn btn-primary">Check Out</button>
        </div>
        </div>
    </div>

    <script type="module">

        const checkoutBtn = document.querySelector('#checkout');


        checkoutBtn.onclick = (e) => {
            let paymentMethod = document.querySelector('input[name=paymentMethod]:checked').value;

            axios.post('/checkout', {
                'paymentMethod': paymentMethod
            }).then(reply=>{

                if(reply.status != 200){
                    alert('Checkout failed');
                    document.location.reload();
                    return false;
                }

                return reply.data;
                
            }).then(reply=>{
                
                if(!reply.status){
                    alert(reply.message);
                    return false;
                }

                let uid     = reply.data.uid;
                let method  = reply.data.method;
                
                console.log(reply);

                switch(method){
                    case 'cc':

                        document.location.href = '/payment/creditcard/'+uid;
                        break;
                    case 'gc':

                        break;

                    default:
                        alert('Unkown payment method '+method);
                }
            });
        }

        Array.from(document.querySelectorAll('.removeBtn')).map(target=>{

            target.onclick = (e)=>{
                let id = target.getAttribute('data-id');

                window.util.removeFromCart(id).then(reply=>{

                    if(!reply.status){
                        alert(reply.message);
                        return false;
                    }

                    
                });
            }
        });
    </script>
@endsection


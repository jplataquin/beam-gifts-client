@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="mt-5 ps-3 pe-3">
            @foreach($items as $item)
                
                <div class="mb-3" id="item-{{$item->id}}">
                    <div class="row bg-darkmagenta mb-2">
                        <div class="col-12 pt-2">
                            <h5 class="fontcolor-white">{{$item->name}}</h5>
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

            
                <div id="emptyPrompt" class="text-center m-5 @if(count($items) == 0) d-block @else d-none @endif">
                    <h3>Your shopping cart is empty, would you like to return to <a href="/">Home</a> screen?</h3>
                </div>
            
        </div>
        
        <div id="paymentMethodBox" class="card mt-5 mb-5 @if(count($items) == 0) d-none @else d-block @endif">
            <div class="card-header">
                Payment Method
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                                <select class="form-control" id="paymentMethod" name="paymentMethod">
                                    <option value="cc">Credit Card</option>
                                    <option value="gc">Gcash</option>
                                </select>
                            </div>
                    </div>
                    <div class="col text-end">
                              
                            <div class="row">
                                <div class="col-md-9 col-sm-6 text-end">
                                    <strong>Total</strong>
                                </div>
                                <div class="col-md-3 col-sm-6" id="total">PHP {{ number_format($total,2) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 text-end font-weight-bold">
                                    <strong>Service Fee</strong>
                                </div>
                                <div class="col-md-3" id="serviceFee">PHP {{ number_format($service_fee,2) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-sm-6 text-end font-weight-bold">
                                    <strong>Payment Processor</strong>
                                </div>
                                <div class="col-md-3 col-sm-6" id="paymentProcessor"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-sm-6 text-end font-weight-bold">
                                    <strong>Grand Total</strong>
                                </div>
                                <div class="col-md-3 col-sm-6" id="grandTotal"></div>
                            </div>
                            

                            <button id="checkout" class="btn btn-primary">Check Out</button>
                    
                    </div>
                </div>
            </div>
        </div>

        
        

    <script type="module">

        const checkoutBtn       = document.querySelector('#checkout');
        const totalEl           = document.querySelector('#total');
        const emptyPrompt       = document.querySelector('#emptyPrompt');
        const paymentMethodBox  = document.querySelector('#paymentMethodBox');
        const serviceFee        = document.querySelector('#serviceFee');
        const paymentProcessor  = document.querySelector('#paymentProcessor');
        const grandTotal        = document.querySelector('#grandTotal');
        const paymentMethod     = document.querySelector('#paymentMethod');

        let paymentCalculation = {{ Illuminate\Support\Js::from($paymentCalculation) }}

        checkoutBtn.onclick = (e) => {


            axios.post('/checkout', {
                'paymentMethod': paymentMethod.value
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
                

                switch(method){
                    case 'cc':

                        document.location.href = '/payment/creditcard/'+uid;
                        break;
                    case 'gc':
                        document.location.href = '/payment/gcash/'+uid;
                        
                        break;

                    default:
                        alert('Unkown payment method '+method);
                }
            }).catch(err=>{
                alert('Something went wrong, unable to proceed');
            });
        }

        /** Remove Item */
        Array.from(document.querySelectorAll('.removeBtn')).map(target=>{

            target.onclick = (e)=>{
                let id = target.getAttribute('data-id');
                
                window.FreezeUI();

                window.util.removeFromCart({id:id}).then(reply=>{

                    window.UnFreezeUI();

                    if(reply.status <= 0){
                        alert(reply.message);
                        return false;
                    }


                    document.querySelector('#item-'+id).remove();

                    totalEl.innerText = window.util.moneyFormat('PHP',reply.data.total);

                    let qty =  Object.keys(reply.data.items).length ?? 0;

                    window.util.cartQuantity(qty);


                    if(qty <= 0){
                        emptyPrompt.classList.remove('d-none'); 
                        emptyPrompt.classList.add('d-block');

                        paymentMethodBox.classList.remove('d-block');
                        paymentMethodBox.classList.add('d-none');
                    }else{
                        emptyPrompt.classList.remove('d-block');
                        emptyPrompt.classList.add('d-none');

                        paymentMethodBox.classList.remove('d-none');
                        paymentMethodBox.classList.add('d-block');
                    }


                    //Update payment Calculation
                    paymentCalculation = reply.data.paymentCalculation;
            
                    updatePayment();

                });
            }
        });

        function updatePayment(){
      
            switch(paymentMethod.value){
                case 'cc':
                    paymentProcessor.innerText = window.util.moneyFormat('PHP',paymentCalculation.cc.payment_processor_fee);
                    grandTotal.innerText = window.util.moneyFormat('PHP',paymentCalculation.cc.grand_total);
                    break;
                case 'gc':
                    paymentProcessor.innerText = window.util.moneyFormat('PHP',paymentCalculation.gc.payment_processor_fee);
                    grandTotal.innerText = window.util.moneyFormat('PHP',paymentCalculation.gc.grand_total);
                    break;
            }
        }

        updatePayment();

        paymentMethod.onchange = (e)=>{
            updatePayment();
        }
    </script>
@endsection
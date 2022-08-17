@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Credit Card Details</h3>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Name of Holder</label>
                <input type="text" id="name" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Card No</label>
                <input type="text" id="ccno" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Expiry Date</label>
                <input type="text" id="expiry" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>CVC</label>
                <input type="text" id="cvc" class="form-control"/>
            </div>
        </div>
    </div>

    <h3>Billing Address</h3>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Address Line 1</label>
                <input type="text" id="address_line_1" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Address Line 2</label>
                <input type="text" id="address_line_2" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>City</label>
                <input type="text" id="city" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>State / Province</label>
                <input type="text" id="state_province" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Postal / Zip Code</label>
                <input type="text" id="postal_zip_code" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Country</label>
                <select class="form-control" id="country">
                    @foreach(config('selectoptions')['countries'] as $key => $text)
                        <option value="{{$key}}">{{$text}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col text-end">
            <button id="payBtn" class="btn btn-primary">Pay Now</button>
        </div>
    </div>
</div>
<script type="module">
    const name      = document.querySelector('#name');
    const ccno      = document.querySelector('#ccno');
    const expiry    = document.querySelector('#expiry');
    const cvc       = document.querySelector('#cvc');
    const payBtn    = document.querySelector('#payBtn');

    expiry.onkeydown = (e)=>{
        
        let charCode = (e.which) ? e.which : event.keyCode;
        
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
        

        let val = expiry.value;

        val = val.replace('/','');

        if(val.length >= 5){
            return false;
        }

        return true;
      
    }

    payBtn.onclick = (e)=>{
        e.preventDefault();
        
        /**
        const formData = new FormData();

        formData.append('name',name.value);
        formData.append('ccno',ccno.value);
        formData.append('expiry',expiry.value);
        formData.append('ccv',ccv.value);
        formData.append('amount',1000);
        **/

        let exp = expiry.value.split('/');

        window.util.$post('/payment/creditcard').then(reply=>{

        
            let clientKey       = reply.data.clientKey;
            let key             = reply.data.key;

            paymentMethod(key,{
                'data':{
                    'attributes':{
                        type:'card',
                        details:{
                            card_number:ccno.value,
                            exp_month: parseInt(exp[0]),
                            exp_year: parseInt(exp[1]),
                            cvc: cvc.value
                        },
                        billing:{
                            address:{
                                line1:'address 1',
                                line2:'address 2',
                                city:'city',
                                state:'state',
                                postal_code:'postal_code',
                                country:'PH'
                            },
                            name:'JasdadP',
                            email:'jp.lataquin@gmail.com',
                            phone:'09088189764',
                            metadata:{
                                hello:'world'
                            }
                        }
                    }
                }
            }).then((response)=>{

                let paymentMethodId = response.data.id;
                

                console.log('payment method',response);
                
                return wtf(paymentMethodId,clientKey,key);
            });
        });
    }


    function paymentMethod(key,data){
        
        console.log(data);

        const options = {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: 'Basic '+key
            },
            body: JSON.stringify(data)
        };

        return fetch('https://api.paymongo.com/v1/payment_methods', options)
        .then(response => { return response.json(); });
    }

    function wtf(paymentMethodId,clientKey,key){

        // Get the payment intent id from the client key
        let paymentIntentId = clientKey.split('_client')[0];

        return axios.post('https://api.paymongo.com/v1/payment_intents/' + paymentIntentId + '/attach',
        {
            data: {
                attributes: {
                    client_key: clientKey,
                    payment_method: paymentMethodId
                }
            }
        },{
            headers: {
                // Base64 encoded public PayMongo API key.
                Authorization: `Basic ${key}`
            }
        }).then(function(response) {
            
            let paymentIntent       = response.data.data;
            let paymentIntentStatus = paymentIntent.attributes.status;
            
            console.log(paymentIntent);
            console.log(paymentIntentStatus);
            console.log(paymentIntent.attributes.next_action);
            if (paymentIntentStatus === 'awaiting_next_action') {
                // Render your modal for 3D Secure Authentication since next_action has a value. You can access the next action via paymentIntent.attributes.next_action.
            } else if (paymentIntentStatus === 'succeeded') {
                // You already received your customer's payment. You can show a success message from this condition.
            } else if(paymentIntentStatus === 'awaiting_payment_method') {
                // The PaymentIntent encountered a processing error. You can refer to paymentIntent.attributes.last_payment_error to check the error and render the appropriate error message.
            }  else if (paymentIntentStatus === 'processing'){
                // You need to requery the PaymentIntent after a second or two. This is a transitory status and should resolve to `succeeded` or `awaiting_payment_method` quickly.
            }
        });

    }


    window.addEventListener('message', ev => {
            
            if (ev.data === '3DS-authentication-complete') {
                // 3D Secure authentication is complete. You can requery the payment intent again to check the status.
            
                axios.get('https://api.paymongo.com/v1/payment_intents/' + paymentIntentId + '?client_key=' + clientKey,{
                    headers: {
                        // Base64 encoded public PayMongo API key.
                        Authorization: `Basic ${key}`
                    }
                }).then(function(response) {
                    let paymentIntent = response.data.data;
                    let paymentIntentStatus = paymentIntent.attributes.status;

                    console.log('oh shet',response);
                    if (paymentIntentStatus === 'succeeded') {
                    // You already received your customer's payment. You can show a success message from this condition.
                    } else if(paymentIntentStatus === 'awaiting_payment_method') {
                    // The PaymentIntent encountered a processing error. You can refer to paymentIntent.attributes.last_payment_error to check the error and render the appropriate error message.
                    } else if (paymentIntentStatus === 'processing'){
                    // You need to requery the PaymentIntent after a second or two. This is a transitory status and should resolve to `succeeded` or `awaiting_payment_method` quickly.
                    }
                });
            }

        },false);
</script>
@endsection
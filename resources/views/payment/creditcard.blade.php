@extends('layouts.app')

@section('content')

<div id="mainContainer" class="container">
    <div id="formContainer">
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
                    <input type="text" id="expiry" placeholder="MM/YY" class="form-control"/>
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
                    <label>Email</label>
                    <input type="text" id="email" class="form-control"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Phone/Mobile No:</label>
                    <input type="text" id="phone" class="form-control"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Address Line 1</label>
                    <input type="text" id="line_address_1" class="form-control"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Address Line 2</label>
                    <input type="text" id="line_address_2" class="form-control"/>
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
</div>


<div id="modal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Please wait</h5>
      </div>
      <div class="modal-body text-center">
            <div>
                    <h3>Processing Payment</h3>
            </div>
            <div>
                <div class="spinner-grow text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div>
                <p>We don't keep record of your Credit Card details</p>
            </div>
      </div>
      <div class="modal-footer justify-content">
            <h5 id="status" class="text-center"></h5>
      </div>
    </div>
  </div>
</div>

<script type="module">
    import {Template} from '/adarna.js';
    import '/bootstrap.js';

    const name              = document.querySelector('#name');
    const ccno              = document.querySelector('#ccno');
    const expiry            = document.querySelector('#expiry');
    const cvc               = document.querySelector('#cvc');
    const line_address_1    = document.querySelector('#line_address_1');
    const line_address_2    = document.querySelector('#line_address_2');
    const state_province    = document.querySelector('#state_province');
    const city              = document.querySelector('#city');
    const country           = document.querySelector('#country');
    const postal_zip_code   = document.querySelector('#postal_zip_code');
    const email             = document.querySelector('#email');
    const phone             = document.querySelector('#phone');
    const payBtn            = document.querySelector('#payBtn');
    const formContainer     = document.querySelector('#formContainer');
    const mainContainer     = document.querySelector('#mainContainer');
    const modalEl           = document.querySelector('#modal');
    const statusEl          = document.querySelector('#status');

    const myModal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false 
    });

    const t         = new Template();
    const iframe    = t.iframe({
        style:{
            display:'block', 
            border:'none',
            height:'100vh',        /* Viewport-relative units */
            width:'100%'
        }
    });

    let paymentMethodId,clientKey,key,paymentIntentId;

    expiry.onkeydown = (e)=>{
        
        let charCode = (e.which) ? e.which : event.keyCode;
        
        if ( !(charCode >= 48 && charCode <= 57) && !(charCode >= 37 && charCode <= 40) && charCode != 8){
            return false;
        }
        
        let val = expiry.value;

        val = val.replace('/','');

        if(val.length <= 4){
            expiry.value = val.substr(0,3);
        }

        if(expiry.value.length == 1){
            expiry.value = expiry.value.substr(0,2) + '/';
        }else if(expiry.value.length == 3){
            expiry.value = expiry.value.substr(0,2) + '/' + expiry.value.substr(2,2); 
        }

      
    }

    expiry.onchange = (e)=>{

        let val = expiry.value;

        if(isNaN( val.replace('/','') )){
            expiry.value = '';
        }
    }

    payBtn.onclick = (e)=>{
       
        e.preventDefault();
        payBtn.disabled = true;
        myModal.show();
        //TODO VALIDATE DETAILS

        statusEl.innerText = 'Sending data';
    

        let exp = expiry.value.split('/');

        window.util.$post('/payment/creditcard').then(reply=>{

            clientKey       = reply.data.clientKey;
            key             = reply.data.key;

            paymentMethod(key,{
                'data':{
                    'attributes':{
                        type:'card',
                        details:{
                            card_number :ccno.value,
                            exp_month   : parseInt(exp[0]),
                            exp_year    : parseInt(exp[1]),
                            cvc         : cvc.value
                        },
                        billing:{
                            address:{
                                line1       :line_address_1.value,
                                line2       :line_address_2.value,
                                city        :city.value,
                                state       :state_province.value,
                                postal_code :postal_zip_code.value,
                                country     :country.value
                            },
                            name    : name.value,
                            email   : email.value,
                            phone   : phone.value,
                            metadata:{}
                        }
                    }
                }
            }).then((response)=>{

                paymentMethodId = response.data.id;
                
                return attach(paymentMethodId,clientKey,key);
            });
        });
    }

    function validate(){
        console.log('validate');
    }

    function showIframe(url){
        formContainer.style.display = 'none';
        iframe.src                  = url;

        mainContainer.append(iframe);
    }

    function success(){
        statusEl.innerText = 'Success';
        console.log('Success');
    }

    function failed(){
        statusEl.innerText = 'Payment Failed';
        console.log('Failed');
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

    function attach(paymentMethodId,clientKey,key){

        // Get the payment intent id from the client key
        paymentIntentId = clientKey.split('_client')[0];

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
            
            console.log('intent',paymentIntent);
            console.log('status',paymentIntentStatus);
            console.log('action',paymentIntent.attributes.next_action);

            if (paymentIntentStatus === 'awaiting_next_action' && paymentIntent.attributes.next_action.type == 'redirect') {
                // Render your modal for 3D Secure Authentication since next_action has a value. You can access the next action via paymentIntent.attributes.next_action.
                statusEl.innerText = 'Required user validation';

                setTimeout(()=>{
                    myModal.hide();
                    showIframe(paymentIntent.attributes.next_action.redirect.url);
                },1000);
              
                
            } else if (paymentIntentStatus === 'succeeded') {
                // You already received your customer's payment. You can show a success message from this condition.
                success(paymentMethodId,paymentIntentId);

            } else if(paymentIntentStatus === 'awaiting_payment_method') {
                // The PaymentIntent encountered a processing error. You can refer to paymentIntent.attributes.last_payment_error to check the error and render the appropriate error message.
                failed(paymentIntent.attributes.last_payment_error);
                
            } else if (paymentIntentStatus === 'processing'){
                statusEl.innerText = 'Pending';
                // You need to requery the PaymentIntent after a second or two. This is a transitory status and should resolve to `succeeded` or `awaiting_payment_method` quickly.
                setTimeout(()=>{
                    attach(paymentMethodId,clientKey,key);
                },2000);
            }else{
                console.log('Unknown status');
            }
            
        }).catch(err=>{
            console.log('HTTP ERROR', err);
        });

    }


    function monitor(paymentMethodId,clientKey,key){

        axios.get('https://api.paymongo.com/v1/payment_intents/' + paymentIntentId + '?client_key=' + clientKey,
        {
            headers: {
                // Base64 encoded public PayMongo API key.
                Authorization: `Basic ${key}`
            }
        }).then(function(response) {
            let paymentIntent       = response.data.data;
            let paymentIntentStatus = paymentIntent.attributes.status;

            if (paymentIntentStatus === 'succeeded') {
            // You already received your customer's payment. You can show a success message from this condition.
                success();
            } else if(paymentIntentStatus === 'awaiting_payment_method') {
            // The PaymentIntent encountered a processing error. You can refer to paymentIntent.attributes.last_payment_error to check the error and render the appropriate error message.
                failed();
            } else if (paymentIntentStatus === 'processing'){
            // You need to requery the PaymentIntent after a second or two. This is a transitory status and should resolve to `succeeded` or `awaiting_payment_method` quickly.
                setTimeout(()=>{
                    monitor(paymentMethodId,clientKey,key);
                },2000);
            }else{
                console.log('Unknown status');
            }
        }).catch(err=>{
            console.log('HTTP ERROR',err);
        });
    }


    window.addEventListener('message', ev => {
            

        if (ev.data === '3DS-authentication-complete') {
            // 3D Secure authentication is complete. You can requery the payment intent again to check the status.
            
            monitor(paymentMethodId,clientKey,key);

        }

    },false);
</script>
@endsection
@extends('layouts.app')

@section('content')

<div id="mainContainer" class="container">
    <div id="formContainer">
        <h3>Credit Card Details</h3>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="name" class="form-control" value="John Patrick Lataquin"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Card No</label>
                    <input type="text" id="ccno" class="form-control" value="4200000000000018"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="text" id="expiry" placeholder="MM/YY" class="form-control" value="02/30"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>CVC</label>
                    <input type="text" id="cvc" class="form-control" value="123"/>
                </div>
            </div>
        </div>

        <h3>Billing Info</h3>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" id="email" class="form-control" value="jp.lataquin@gmail.com"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Phone/Mobile No:</label>
                    <input type="text" id="phone" class="form-control" value="09088189764"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Address Line 1</label>
                    <input type="text" id="line_address_1" class="form-control" value="line1"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Address Line 2</label>
                    <input type="text" id="line_address_2" class="form-control" value="line2"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" id="city" class="form-control" value="city"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>State / Province</label>
                    <input type="text" id="state_province" class="form-control" value="state"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="form-group">
                    <label>Postal / Zip Code</label>
                    <input type="text" id="postal_zip_code" class="form-control" value="5000"/>
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
        <h5 class="modal-title" id="modalTitle">Please wait</h5>
      </div>
      <div class="modal-body text-center">
            <div>
                    <h3 id="mTitle">Processing Payment</h3>
            </div>
            <div id="info" class="text-center">
            </div>
            <div id="loading">
                <div class="spinner-grow text-primary" role="status">
                    <span class="visually-hidden"></span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden"></span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="visually-hidden"></span>
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
    const infoEl            = document.querySelector('#info');
    const loadingEl         = document.querySelector('#loading');
    const mTitle            = document.querySelector('#mTitle');
    const modalTitle        = document.querySelector('#modalTitle');

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

    iframe.onload = ()=>{
        console.log('here');
        myModal.hide();
    };

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
      
    }

    expiry.onkeyup = (e) => {
        let val = expiry.value;
        val = val.replace('/','');
        
        if(val.length == 2){
            expiry.value = val + '/';
        }else if(val.length > 2){
            expiry.value = val.substr(0,2) + '/' + val.substr(2,2);
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
                            card_number : ccno.value,
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

                //TODO Validation of response


                paymentMethodId = response.data.id;
                
                return attach(paymentMethodId,clientKey,key);
            }).catch(err=>{
                console.log('HERE ERROR');
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

    function success(paymentIntent,paymentMethodId,paymentIntentId){
        
        iframe.style.display = 'none';
        statusEl.innerText = 'Success';
        console.log('Success');

        console.log(paymentIntent,paymentMethodId,paymentIntentId);
    }

    function failed(type,data,paymentMethodId,paymentIntentId){
        
        console.log(data);
        modalTitle.innerText    = 'Uh-oh';
        mTitle.innerText        = 'Failed';
        statusEl.innerText      = '';
        
        if(type == 1){ //Validation Error
            loadingEl.style.display = 'none';
            infoEl.innerHTML = `<p class="text-danger">*** You have not been charged ***</p>
                <p class="text-danger">Invalid data</p>
                <a href="/cart" class="btn btn-warning mr-3" role="button">Cancel</a>
                <a href="javascript:window.location.href=window.location.href" class="btn btn-primary" role="button">Retry?</a>
            `;
        }else if(type == 2){ //Connection Error
            loadingEl.style.display = 'none';
            infoEl.innerHTML = `<p class="text-danger">*** You have not been charged ***</p>
                <p class="text-danger">Payment Provider Unreachable</p>
                <a href="/cart" class="btn btn-warning mr-3" role="button">Cancel</a>
                <a href="javascript:window.location.href=window.location.href" class="btn btn-primary" role="button">Retry?</a>
            `;
        }else if(type == 3){ //Transaction Error
            loadingEl.style.display = 'none';
            infoEl.innerHTML = `<p class="text-danger">*** You have not been charged ***</p>
                <p class="text-danger">Something Went Wrong</p>
                <a href="/cart" class="btn btn-warning mr-3" role="button">Cancel</a>
                <a href="javascript:window.location.href=window.location.href" class="btn btn-primary" role="button">Retry?</a>`;

        }else if(type == 4){ //Unkown Reply
            infoEl.innerHTML = `<p class="text-danger">*** You have not been charged ***</p>
                <p class="text-danger">Unkown status reply from Payment Provider (${data})</p>
                <a href="/cart" class="btn btn-warning mr-3" role="button">Cancel</a>
                <a href="javascript:window.location.href=window.location.href" class="btn btn-primary" role="button">Retry?</a>`;
        }else if(type == 5){ //Subcode error
            console.log('whats up');
            infoEl.innerHTML = '';

            let el = t.div(()=>{
                    
                    t.p({class:'text-danger'},'*** You have not been charged ***');
                    
                    data.map(item=>{
                        t.p({class:'text-danger'},item.detail);
                    });

                    t.a({
                        class:'btn btn-warning mr-3',
                        href:'/cart',
                        role:'button'
                    },'Cancel');

                    t.a({
                        class:'btn btn-primary',
                        href:'javascript:window.location.href=window.location.href',
                        role:'button'
                    },'Retry');
                    
                });

                console.log(el);

            infoEl.append(el);//End append
        }

    }

    function paymentMethod(key,data){
        
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
        .then(response=>{
            
            if(response.status == 400){

                response.json().then(data => {
                    failed(1,data,paymentMethodId,paymentIntentId);
                });
                
                throw new Error('Something went wrong');
            }else if(response.status == 200){
             
                return response;
            
            }else{

                response.json().then(data => {
                    failed(2,data,paymentMethodId,paymentIntentId);
                });

                throw new Error('Server Error');
            }

        }).then(response => { 
            return response.json(); 
        });
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
            
      
            if (paymentIntentStatus === 'awaiting_next_action' && paymentIntent.attributes.next_action.type == 'redirect') {
                // Render your modal for 3D Secure Authentication since next_action has a value. You can access the next action via paymentIntent.attributes.next_action.
                statusEl.innerText = 'User Validation';
                loadingEl.style.display = 'none';
                infoEl.innerHTML = "<h3>Redirecting...</h3>"
                
                showIframe(paymentIntent.attributes.next_action.redirect.url);
                              
                
            } else if (paymentIntentStatus === 'succeeded') {
                // You already received your customer's payment. You can show a success message from this condition.
                success(paymentIntent,paymentMethodId,paymentIntentId);

            } else if(paymentIntentStatus === 'awaiting_payment_method') {
                // The PaymentIntent encountered a processing error. You can refer to paymentIntent.attributes.last_payment_error to check the error and render the appropriate error message.
                failed(3,paymentIntent.attributes.last_payment_error,paymentMethodId,paymentIntentId);
                
            } else if (paymentIntentStatus === 'processing'){
                
                statusEl.innerText = 'Pending';
                
                // You need to requery the PaymentIntent after a second or two. This is a transitory status and should resolve to `succeeded` or `awaiting_payment_method` quickly.
                setTimeout(()=>{
                    attach(paymentMethodId,clientKey,key);
                },2000);

            }else{
                failed(4,paymentIntentStatus,paymentMethodId,paymentIntentId);
            }
            
        }).catch(err=>{
            console.log(err);
            console.log('x',err.response);
            if(typeof err['response'] != 'undefined'){

                if(err.response == 400){
                    console.log('here 400',err.response.data.errors);
                    failed(5,err.response.data.errors,paymentMethodId,paymentIntentId);
                }else{
                    failed(6,err.response,paymentMethodId,paymentIntentId);
                }
            }

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
                success(paymentIntent,paymentMethodId,paymentIntentId);
            } else if(paymentIntentStatus === 'awaiting_payment_method') {
            // The PaymentIntent encountered a processing error. You can refer to paymentIntent.attributes.last_payment_error to check the error and render the appropriate error message.
                failed(3,paymentIntent.attributes.last_payment_error,paymentMethodId,paymentIntentId);
            } else if (paymentIntentStatus === 'processing'){
            // You need to requery the PaymentIntent after a second or two. This is a transitory status and should resolve to `succeeded` or `awaiting_payment_method` quickly.
                setTimeout(()=>{
                    monitor(paymentMethodId,clientKey,key);
                },2000);
            }else{
                failed(4,paymentIntentStatus,paymentMethodId,paymentIntentId);
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
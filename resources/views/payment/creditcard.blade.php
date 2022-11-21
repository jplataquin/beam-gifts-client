@extends('layouts.app')

@section('content')


<section class="checkout-form py-5" id="mainContainer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 my-2">
                    <div class="left-col border rounded p-0">
                        <div class="checkout-formCont p-3">
                            <h4 class="mb-3">Enter your card details.</h4>
                            <p class="grand-total">
                                <strong>Grand Total</strong><span class="fs-4 ms-1">PHP {{number_format($order->amount,2)}}</span>
                            </p>
                            <form action="">
                                <div class="form-field">
                                    <label for="name" class="checkout-label fs-6">Name on card:</label><br>
                                    <input type="text" name="name" id="name" class="input-field my-1 col-12 fs-6" placeholder="Enter Name">
                                </div>
                                <div class="form-field mt-2">
                                    <label for="number" class="checkout-label fs-6">Card No:</label><br>
                                    <input type="text" name="number" id="ccno" class="input-field my-1 col-12 fs-6" placeholder="1111 **** **** ****">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="date" class="checkout-label fs-6">Expiry date:</label><br>
                                            <input type="text" name="date" id="expiry" class="input-field my-1 col-12 fs-6" placeholder="MM/YY">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="CVC" class="checkout-label fs-6">CVC:</label><br>
                                            <input type="password" name="CVC" id="cvc" class="input-field my-1 col-12 fs-6" placeholder="***">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-field mt-2">
                                    <label for="payemail" class="checkout-label fs-6">Email address:</label><br>
                                    <input type="email" name="payemail" id="email" class="input-field my-1 col-12 fs-6" placeholder="Enter Email address">
                                </div>
                                <div class="form-field mt-2">
                                    <label for="number" class="checkout-label fs-6">Phone/Mobile No:</label><br>
                                    <input type="text" name="number" id="phone" class="input-field my-1 col-12 fs-6" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-field mt-2">
                                    <label for="Address1" class="checkout-label fs-6">Address Line 1:</label><br>
                                    <input type="text" name="Address1" id="line_address_1" class="input-field my-1 col-12 fs-6" placeholder="Enter Line Address 1">
                                </div>
                                <div class="form-field mt-2">
                                    <label for="Address2" class="checkout-label fs-6">Address Line 2:</label><br>
                                    <input type="text" name="Address2" id="line_address_2" class="input-field my-1 col-12 fs-6" placeholder="Enter Line Address 2">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="number" class="checkout-label fs-6">Choose country</label><br>
                                            <select class="form-select input-field my-1 col-12 fs-6" id="country">
                                                @foreach(config('selectoptions')['countries'] as $key => $text)
                                                    <option value="{{$key}}">{{$text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="city" class="checkout-label fs-6">State/Provice</label><br>
                                            <input type="text" name="state_province" id="state_province" class="input-field my-1 col-12 fs-6" placeholder="Enter State/Provice">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="city" class="checkout-label fs-6">City</label><br>
                                            <input type="text" name="city" id="city" class="input-field my-1 col-12 fs-6" placeholder="Enter City">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="CVC" class="checkout-label fs-6">Postal code:</label><br>
                                            <input type="text" name="postal_zip_code" id="postal_zip_code" class="input-field my-1 col-12 fs-6" placeholder="Enter Postal Code">
                                        </div>
                                    </div>
                                </div>
                                <button class="mt-3 col-12 submitBTN" id="payBtn" >Pay now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



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
    import {Template, util} from '/adarna.js';
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

    const cardRegex = {
        'mastercard' : /^5[1-5][0-9]{14}$|^2(?:2(?:2[1-9]|[3-9][0-9])|[3-6][0-9][0-9]|7(?:[01][0-9]|20))[0-9]{12}$/,
        'americanexpress' : /^3[47][0-9]{13}$/,
        'visa': /^4[0-9]{12}(?:[0-9]{3})?$/,
        'discovery': /^65[4-9][0-9]{13}|64[4-9][0-9]{13}|6011[0-9]{12}|(622(?:12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])[0-9]{10})$/,
        'maestro': /^(5018|5081|5044|5020|5038|603845|6304|6759|676[1-3]|6799|6220|504834|504817|504645)[0-9]{8,15}$/,
        'jcb': /^(?:2131|1800|35[0-9]{3})[0-9]{11}$/,
        'diners': /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/
    }

    iframe.onload = ()=>{
        console.log('here');
        myModal.hide();
    };

    let paymentMethodId,clientKey,key,paymentIntentId;

    function insertAtCaret(newText, el = document.activeElement) {
        
        console.log(el);

        const [start, end] = [el.selectionStart, el.selectionEnd];

        console.log(start,end);
        
        el.setRangeText(newText, start, end);
    }

    ccno.onkeypress = (e)=>{
        e.preventDefault();

        let val = String.fromCharCode(e.keyCode);
        
        let oldVal = ccno.value;

        let newVal =oldVal.match(/.{1,4}/g);

        ccno.value = newVal.join();
    }

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

        const formData = new FormData();

        formData.append('uid','{{$uid}}');

        window.util.$post('/payment/creditcard',formData).then(reply=>{

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

                console.log('HERE ERROR',err);

                failed(2,err,paymentMethodId,paymentIntentId);
                
            });

        }).catch(err=>{
            failed(2,err,paymentMethodId,paymentIntentId);
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

        document.location.href = '/myorders/{{$uid}}';
    }

    function failed(type,data,paymentMethodId,paymentIntentId){
        
        console.log('FAILED',type,data);

        modalTitle.innerText    = 'Uh-oh';
        mTitle.innerText        = 'Failed';
        statusEl.innerText      = '';
        loading.style.display   = 'none';
        
        if(type == 1){ //Validation Error
            
            infoEl.innerHTML = '';

            infoEl.append(
                t.div(()=>{
                    
                    t.p({class:'text-danger'},'*** You have not been charged ***');
                    
                    t.p({class:'text-danger'},'Invalid data input');
                    
                    t.div({class:'mb-3'},()=>{
                        t.a({
                            class:'btn btn-warning me-3',
                            href:'/cart',
                            role:'button'
                        },'Cancel');

                        t.a({
                            class:'btn btn-primary',
                            href:'javascript:window.location.href=window.location.href',
                            role:'button'
                        },'Retry');
                    })
                   
                })
            );//End append

        }else if(type == 2){ //Connection Error
            infoEl.innerHTML = '';

            infoEl.append(
                t.div(()=>{
                    
                    t.p({class:'text-danger'},'*** You have not been charged ***');
                    
                    t.p({class:'text-danger'},'Connection Error');
                    
                    t.div({class:'mb-3'},()=>{
                        t.a({
                            class:'btn btn-warning me-3',
                            href:'/cart',
                            role:'button'
                        },'Cancel');

                        t.a({
                            class:'btn btn-primary',
                            href:'javascript:window.location.href=window.location.href',
                            role:'button'
                        },'Retry');
                    })
                   
                })
            );//End append

        }else if(type == 3){ //Transaction Error
            
            infoEl.innerHTML = '';

            infoEl.append(
                t.div(()=>{
                    
                    t.p({class:'text-danger'},'*** You have not been charged ***');
                    
                    t.p({class:'text-danger'},'Transaction Error: '+data);
                    
                    t.div({class:'mb-3'},()=>{
                        t.a({
                            class:'btn btn-warning me-3',
                            href:'/cart',
                            role:'button'
                        },'Cancel');

                        t.a({
                            class:'btn btn-primary',
                            href:'javascript:window.location.href=window.location.href',
                            role:'button'
                        },'Retry');
                    })
                
                })
            );//End append

        }else if(type == 4){ //Unkown Reply Ststus

            infoEl.innerHTML = '';

            infoEl.append(
                t.div(()=>{
                    
                    t.p({class:'text-danger'},'*** You have not been charged ***');
                    
                    t.p({class:'text-danger'},`Unkown reply status from Payment Provider (${data})`);
                    
                    t.div({class:'mb-3'},()=>{
                        t.a({
                            class:'btn btn-warning me-3',
                            href:'/cart',
                            role:'button'
                        },'Cancel');

                        t.a({
                            class:'btn btn-primary',
                            href:'javascript:window.location.href=window.location.href',
                            role:'button'
                        },'Retry');
                    })
                   
                })
            );//End append
        
        }else if(type == 5){ //Subcode error
        
            infoEl.innerHTML = '';

            infoEl.append(
                t.div(()=>{
                    
                    t.p({class:'text-danger'},'*** You have not been charged ***');
                    
                    data.map(item=>{
                        t.p({class:'text-danger'},item.detail);
                    });

                    t.div({class:'mb-3'},()=>{
                        t.a({
                            class:'btn btn-warning me-3',
                            href:'/cart',
                            role:'button'
                        },'Cancel');

                        t.a({
                            class:'btn btn-primary',
                            href:'javascript:window.location.href=window.location.href',
                            role:'button'
                        },'Retry');
                    })
                   
                })
            );//append()
        }

    }//failed()

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

        return fetch('https://api.paymongo.com/v1/payment_methods', options).then(response=>{
            
            if(response.ok){
               
                return response;
            
            }else if(response.status == 400){

                response.json().then(data => {
                    failed(1,data,paymentMethodId,paymentIntentId);
                });
                
                throw new Error(response);

            }else{

                throw new Error(response);
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
                //Transaction Error
                failed(3,paymentIntent.attributes.last_payment_error,paymentMethodId,paymentIntentId);
                
            } else if (paymentIntentStatus === 'processing'){
                
                statusEl.innerText = 'Pending';
                
                // You need to requery the PaymentIntent after a second or two. This is a transitory status and should resolve to `succeeded` or `awaiting_payment_method` quickly.
                setTimeout(()=>{
                    attach(paymentMethodId,clientKey,key);
                },2000);

            }else{
                //Unkown reply status Error
                failed(4,paymentIntentStatus,paymentMethodId,paymentIntentId);
            }
            
        }).catch(err=>{

            if(err.response.status == 400){
            
                //Subcode error
                failed(5,err.response.data.errors,paymentMethodId,paymentIntentId);
            
            }else{ 

                //Connection Error
                failed(2,err.response,paymentMethodId,paymentIntentId);
            }

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
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
                                    <label for="name" class="checkout-label fs-6 ">Name on card:</label><br>
                                    <input type="text" name="name" id="name" class="input-field my-1 col-12 fs-6 v-required" placeholder="Enter Name">
                                </div>
                                <div class="form-field mt-2">
                                    <label for="number" class="checkout-label fs-6">Card No:</label><br>
                                    <input type="text" name="number" id="ccno" class="input-field my-1 col-12 fs-6" placeholder="1111 **** **** ****">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="date" class="checkout-label fs-6">Expiry date:</label><br>
                                            <input type="text" name="date" id="expiry" class="input-field my-1 col-12 fs-6 v-required" placeholder="MM/YY">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="CVC" class="checkout-label fs-6">CVC:</label><br>
                                            <input type="password" name="CVC" id="cvc" class="input-field my-1 col-12 fs-6 v-required" placeholder="***">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-field mt-2">
                                    <label for="payemail" class="checkout-label fs-6">Email address:</label><br>
                                    <input type="email" name="payemail" id="email" class="input-field my-1 col-12 fs-6 v-required" placeholder="Enter Email address">
                                </div>
                                <div class="form-field mt-2">
                                    <label for="number" class="checkout-label fs-6">Phone/Mobile No:</label><br>
                                    <input type="text" name="number" id="phone" class="input-field my-1 col-12 fs-6 v-required" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-field mt-2">
                                    <label for="Address1" class="checkout-label fs-6">Address Line 1:</label><br>
                                    <input type="text" name="Address1" id="line_address_1" class="input-field my-1 col-12 fs-6 v-required" placeholder="Enter Line Address 1">
                                </div>
                                <div class="form-field mt-2">
                                    <label for="Address2" class="checkout-label fs-6">Address Line 2:</label><br>
                                    <input type="text" name="Address2" id="line_address_2" class="input-field my-1 col-12 fs-6" placeholder="Enter Line Address 2">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="number" class="checkout-label fs-6">Choose country</label><br>
                                            <select class="form-select input-field my-1 col-12 fs-6 v-required" id="country">
                                                @foreach(config('selectoptions')['countries'] as $key => $text)
                                                    <option value="{{$key}}" @if($key == 'PH') selected="true" @endif >{{$text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="city" class="checkout-label fs-6">State/Provice</label><br>
                                            <input type="text" name="state_province" id="state_province" class="input-field my-1 col-12 fs-6 v-required" placeholder="Enter State/Provice">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="city" class="checkout-label fs-6">City</label><br>
                                            <input type="text" name="city" id="city" class="input-field my-1 col-12 fs-6 v-required" placeholder="Enter City">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-field mt-2">
                                            <label for="CVC" class="checkout-label fs-6">Postal code:</label><br>
                                            <input type="text" name="postal_zip_code" id="postal_zip_code" class="input-field my-1 col-12 fs-6 v-required" placeholder="Enter Postal Code">
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
    import {Template, util, $q} from '/adarna.js';
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

    let paymentMethodId,clientKey,key,paymentIntentId;

    iframe.onload = ()=>{
        myModal.hide();
    };

    ccno.onkeydown = (e)=>{
        let keyCode = e.which ? e.which : e.keyCode;
        
        return ((keyCode >= 48 && keyCode <= 57) || keyCode == 8);
    }

    ccno.onkeyup = (e)=>{

        let keyCode = e.which ? e.which : e.keyCode;

        if(!((keyCode >= 48 && keyCode <= 57) || keyCode == 8)){
            return false;
        }

        let oldVal = ccno.value.replaceAll(' ','');

        let newVal = oldVal.match(/.{1,4}/g);
        
        if(newVal != null){
            ccno.value = newVal.join(' ');
        }
        
    }

    ccno.onchange = (e)=>{

        let oldVal = ccno.value.replaceAll(' ','');

        let newVal = oldVal.match(/.{1,4}/g);

        if(newVal != null){
            ccno.value = newVal.join(' ');
        }

    }

    ccno.onpaste = (e)=>{

        let clipboardData   = e.clipboardData || window.clipboardData;
        let pastedData      = clipboardData.getData('Text');

        setTimeout(()=>{
            ccno.onchange();
        },0);

        return /^\d+$/.test(pastedData);
    }


    expiry.onkeydown = (e)=>{
        
        let charCode = (e.which) ? e.which : event.keyCode;
        
        //if not numeric
        if ( !(charCode >= 48 && charCode <= 57) && !(charCode >= 37 && charCode <= 40) && charCode != 8 && charCode != 9){
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

        //TODO VALIDATE DETAILS
        if(!validate()){
            return false;
        }
        
        
        payBtn.disabled = true;
        myModal.show();
        
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
                            card_number : ccno.value.replaceAll(' ',''),
                            exp_month   : parseInt(exp[0]),
                            exp_year    : parseInt(exp[1]),
                            cvc         : cvc.value.trim()
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


                if(err.status == 400){
                    err.json().then(data => {
                        failed(1,data,paymentMethodId,paymentIntentId);
                    });
                }else{
                    failed(2,err,paymentMethodId,paymentIntentId);
                }
               
                
            });

        }).catch(err=>{
            failed(2,err,paymentMethodId,paymentIntentId);
        });
    }

    function validateCardNumber(number){
        
        //Check if the number contains only numeric value  
        //and is of between 13 to 19 digits
        const regex = new RegExp("^[0-9]{13,19}$");
        if (!regex.test(number)){
            return false;
        }

        return luhnCheck(number);
    }

    function luhnCheck(val){
        let checksum = 0; // running checksum total
        let j = 1; // takes value of 1 or 2

        // Process each digit one by one starting from the last
        for (let i = val.length - 1; i >= 0; i--) {
            let calc = 0;
            // Extract the next digit and multiply by 1 or 2 on alternative digits.
            calc = Number(val.charAt(i)) * j;

            // If the result is in two digits add 1 to the checksum total
            if (calc > 9) {
                checksum = checksum + 1;
                calc = calc - 10;
            }

            // Add the units element to the checksum total
            checksum = checksum + calc;

            // Switch the value of j
            if (j == 1) {
                j = 2;
            } else {
                j = 1;

            }
        }

        //Check if it is divisible by 10 or not.
        return (checksum % 10) == 0;
    }


    function validateEmail(email){
        return String(email)
            .toLowerCase()
            .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
    }

    function validate(){

        //Remove all invalid classes
        $q('.input-field-invalid').apply((el)=>{

            el.classList.remove('input-field-invalid');
        });

        let creditCardNo = ccno.value.replaceAll(' ','');

        let flag = true;
        
        //Validate creditcard
        if(!validateCardNumber(creditCardNo)){

            ccno.classList.add('input-field-invalid');
            flag = false;
        }


        if(!validateEmail(email.value)){
            email.classList.add('input-field-invalid');
            flag = false;
        }

        $q('.v-required').apply((el)=>{

            if(el.value.trim() == ''){
                flag = false;
                el.classList.add('input-field-invalid');
            }
           
        });

        if(!flag){
            $q('.input-field-invalid').first().focus();
        }

        return flag;
    }

    function showIframe(url){
        formContainer.style.display = 'none';
        iframe.src                  = url;
        mainContainer.append(iframe);
    }

    function success(paymentIntent,paymentMethodId,paymentIntentId){
        
        iframe.style.display = 'none';
        statusEl.innerText = 'Success';
        document.location.href = '/myorders/{{$uid}}';
    }

    function failed(type,data,paymentMethodId,paymentIntentId){
        
        modalTitle.innerText    = 'Uh-oh';
        mTitle.innerText        = 'Failed';
        statusEl.innerText      = '';
        loading.style.display   = 'none';
        
        let message = t.p({class:'text-danger'},'');
            
        let prompt = t.div(()=>{
                    
            t.p({class:'text-danger'},'*** You have NOT been charged ***');
            
            t.el(message);

            t.div({class:'mb-3'},()=>{
                
                t.a({
                    class:'btn btn-warning me-3',
                    role:'button'
                },'Cancel').onclick = (e)=>{
                    e.preventDefault();

                    if(confirm('Are you sure you want to cancel this transation?')){
                        document.location.href = '/cart';
                    }

                }

                t.a({
                    class:'btn btn-primary',
                    href:'javascript:window.location.href=window.location.href',
                    role:'button'
                },'Retry');
            })
            
        });

        infoEl.innerHTML = '';

        infoEl.append(prompt);
        
        console.log(type);

        if(type == 1){ //Validation Error
            
            message.innerText = 'One or more of the data you entered is invalid';
           

        }else if(type == 2){ //Connection Error
            
            message.innerText = 'Connection Error';
           
            
        }else if(type == 3){ //Transaction Error
            
            message.innerText = 'Transaction Error: '+data;

        }else if(type == 4){ //Unkown Reply Ststus

            message.innerText = `Unkown reply status from Payment Provider (${data})`;
        
        }else if(type == 5){ //Subcode error
        
            infoEl.innerHTML = '';

            infoEl.append(
                t.div(()=>{
                    
                    t.p({class:'text-danger'},'*** You have NOT been charged ***');
                    
                    data.map(item=>{
                        t.p({class:'text-danger'},item.detail);
                    });

                    t.div({class:'mb-3'},()=>{
                        t.a({
                            class:'btn btn-warning me-3',
                            href:'/cart',
                            role:'button'
                        },'Cancel').onclick = (e)=>{
                            e.preventDefault();

                            if(confirm('Are you sure you want to cancel this transation?')){
                                document.location.href = '/cart';
                            }

                        };

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
            
            }else{

                throw response;
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
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Name</label>
                <input type="text" id="name" class="form-control"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label>Credit Card No</label>
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
                <label>CCV</label>
                <input type="text" id="ccv" class="form-control"/>
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
    const ccv       = document.querySelector('#ccv');
    const payBtn    = document.querySelector('#payBtn');

    payBtn.onclick = (e)=>{
        e.preventDefault();
        
        const formData = new FormData();

        formData.append('name',name.value);
        formData.append('ccno',ccno.value);
        formData.append('expiry',expiry.value);
        formData.append('ccv',ccv.value);
        formData.append('amount',1000);

        window.util.$post('/payment/creditcard',formData).then(reply=>{

            console.log(reply)
        });
    }
</script>
@endsection
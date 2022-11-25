@extends('layouts.qr')

@section('content')


<div class="container">
    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <img src="{{ asset('images/gift-1.png') }}" width="60px" />
            <img class="logo" src="{{ asset('images/logo.png') }}" alt="">
            <img src="{{ asset('images/gift-1.png') }}" width="60px" />
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pt-3">
            <div class="border border-primary mb-3 p-3 text-center">
                <h3>You received an E-gift from:</h3>
                <h3>{{$user->firstname}} {{$user->lastname}}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 text-center">
            <img class="img mb-3" width="100%" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$photo['400px']}}"/>    
            
            <div class="border border-primary mb-3 d-lg-none"> 
                <h2 class="mb-3 pt-2">{{$item->item_name}}</h2>
            </div>
        </div>
        <div class="col-md-6">

            <div class="qr_container" style="margin-bottom:9.1px"> 
                <div class="text-center" width="100%" id="qr_logo"></div>
            </div>
                
            <div class="border border-primary text-center d-lg-none"> 
                <h2 class="mb-3 pt-2">🎁: {{$item->consumed}} / {{$item->quantity}} </h2>
            </div>
       </div>   
    </div>

    <div class="d-none d-lg-block">
        <div class="row">
            <div class="col-md-6">
                <div class="border border-primary mb-3 text-center"> 
                    <h2 class="mb-3 pt-2"> {{$item->item_name}}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border border-primary text-center"> 
                    <h2 class="mb-3 pt-2">🎁: {{$item->consumed}} / {{$item->quantity}} </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-12  text-center">
            <hr>
            <h5 style="font-weight:bold">By: </h5>
            <img class="img mb-3" width="150px" src="{{config('app')['api_base_url']}}storage/photos/brand/150px/{{ json_decode($brand->photo,true)['150px'] }}"/>    
            <h5>{{$brand->name}}</h5> 

        </div>
    </div>
   
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" href="#"  data-bs-toggle="tab" data-bs-target="#howto-tab-pane" role="tab" aria-controls="howto-tab-pane" aria-selected="true">How to Claim?</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" href="#"  data-bs-toggle="tab" data-bs-target="#stores-tab-pane" role="tab" aria-controls="stores-tab-pane" aria-selected="true">Branches</button>
                </li>
            </ul>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="howto-tab-pane" role="tabpanel" aria-labelledby="howto-tab" tabindex="0">
                    <h5>Step 1</h5>
                    <p class="mb-3">Choose and visit a participating branch.</p>

                    <h5>Step 2</h5>
                    <p class="mb-3">Inform their staff that you want to claim an E-gift.</p>

                    <h5>Step 3</h5>
                    <p class="mb-3">Have them scan your QR code, and wait for the validation.</p>

                    <h5>Step 4</h5>
                    <p class="mb-3">Once validation is completed you can claim your E-gift</p>
                    
                    <hr>
                    
                    <h5>*** Item Availablity ***</h5>
                    <p class="">
                        In the event that your item is not available, you can opt to substitute it for a different item with equal or lower value.
                        <br>
                        Note that if you decide to accept an item of lower value, you will not receive monetary change for the difference in amount and your E-gift will be considered consumated.
                    </p>
                    
                    <hr>

                    <h5>Contact Us</h5>
                    <p class="">
                        In the event that you have any questions or clarifications you can contact us at
                        <ul>
                            <li>Email: </li>
                            <li>Mobile: </li>
                        </ul>
                    </p>

                </div>
                <div class="tab-pane fade show" id="stores-tab-pane" role="tabpanel" aria-labelledby="howto-tab" tabindex="0">
                

                    <div class="branchList">
                        @foreach(json_decode($brand->branches,true) as $branch)
                            <div class="border border-primary p-1 mb-2">
                                <h5>{{$branch['name']}}</h5>
                                <label>{{$branch['address']}}</label>
                                <h6>{{$branch['phone']}}</h6>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .qr_container canvas{
        width: 100% !important;
    }
</style>

<script type="module">
    import '/easyqrcode.js';

    new QRCode(document.getElementById('qr_logo'), {			
        text: JSON.stringify({
            item_uid: '{{$item->item_uid}}'
        }),
        
        width: 300,
        height: 300,
        colorDark: "#000000",

        PI: '#00008F',

        correctLevel: QRCode.CorrectLevel.H, // L, M, Q, H

        //logo: 'logo.png',
        logoWidth: 43, // fixed logo width. default is `width/3.5`
        logoHeight: 43,
        autoColor: true,
    
        dotScale: 0.7,
        drawer: 'canvas',
        onRenderingEnd: function(qrCodeOptions) {
            
        },
    });
</script>

 

@endsection
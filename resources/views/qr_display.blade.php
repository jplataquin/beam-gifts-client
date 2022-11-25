@extends('layouts.qr')

@section('content')


<div class="container">
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
            <div class="border border-primary mb-3"> 
                <h2 class="mt-3 mb-3 p-2">{{$item->item_name}}</h2>
            </div>
        </div>
        <div class="col-md-6">

            <div class="qr_container"> 
                <div class="text-center mb-3" width="100%" id="qr_logo"></div>
            </div>
                
            <div class="border border-primary mb-3 text-center"> 
                <h2 class="mt-3 mb-3 p-2">Used: {{$item->consumed}} / {{$item->quantity}}</h2>
            </div>
       </div>   
    </div>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" href="#"  data-bs-toggle="tab" data-bs-target="#howto-tab-pane" role="tab" aria-controls="howto-tab-pane" aria-selected="true">How to Claim?</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" href="#"  data-bs-toggle="tab" data-bs-target="#stores-tab-pane" role="tab" aria-controls="stores-tab-pane" aria-selected="true">How to Claim?</button>
                </li>
            </ul>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="howto-tab-pane" role="tabpanel" aria-labelledby="howto-tab" tabindex="0">
                    <p>1</p>
                </div>
                <div class="tab-pane fade show active" id="stores-tab-pane" role="tabpanel" aria-labelledby="howto-tab" tabindex="0">
                    <p>2</p>
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
@extends('layouts.qr')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12 pt-3">
            <div class="border border-primary mb-3 p-3">
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

            <div style="padding:auto"> 
                <div class="text-center mb-3" width="100%" id="qr_logo"></div>
                
                
                <div class="border border-primary mb-3 text-center"> 
                    <h2 class="mt-3 mb-3 p-2">Used: {{$item->consumed}} / {{$item->quantity}}</h2>
                </div>
            </div>
        </div>
        
    </div>

</div>


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
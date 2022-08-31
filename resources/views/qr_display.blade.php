@extends('layouts.qr')

@section('content')

<div class="row">
    <div class="col pt-3">
            <div class="border border-primary mb-3 p-3">

                <h3>A gift from</h3>
                <h3>{{$user->name}}</h3>
            </div>

            <div class="text-center">
                <img class="img mb-3" width="100%" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$photo['400px']}}"/>
                
                <div class="border border-primary mb-3"> 
                    <h2 class="mt-3 mb-3">{{$item->item_name}}</h2>
                </div>
            </div>

            <div class="mt-3">

                <div class="text-center" width="100%" id="qr_logo"></div>
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

            </div>
            
            <div class="text-center">
                <div class="border border-primary mb-3"> 
                    <h2 class="mt-3 mb-3">{{$item->consumed}} / {{$item->quantity}}</h2>
                </div>
            </div>
    </div>

</div>

@endsection
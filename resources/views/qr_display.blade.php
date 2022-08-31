@extends('layouts.qr')

@section('content')

<div class="row">
    <div class="col">
            <div>
                <h3>A gift from {{$user->name}}</h3>
            </div>

            <div class="text-center">
                <img class="img mb-3" width="100%" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$photo['400px']}}"/>
                <h2 class="mt-3 mb-3">{{$item->item_name}}</h2>
                

                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-sm-2">
                        <img width="50px" src="{{config('app')['api_base_url']}}storage/photos/item/150px/{{$photo['150px']}}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-sm-10">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>

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
    </div>

</div>

@endsection
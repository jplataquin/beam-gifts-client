@extends('layouts.app')

@section('content')


  <!-- Hero Section -->

  <section class="hero">
    <div class="custom-container">
        <div class="row align-items-center">
            <div class="col-md-6 py-5">
                <h1 class="heroT">Find the perfect gift<br>to South Korea</h1>
                <p class="heroD">Gift whenever and wherever.</p>
                <button class="button gift-btn mt-2">Send Gift Now</button>
            </div>
            
            <div class="col-md-6">
                <img src="{{asset('images/new_main_kr.png')}}" alt="" width="100%">
            </div>
        </div>
    </div>
</section>


<div class="container">
    


 <!-- Ocassions -->
    <section class="occasions py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="occasion p-2 my-2" href="#">
                        <img class="occasionImg m-auto mb-2" src="{{ asset('images/new.png') }}" alt="">
                        New Gifts
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="occasion p-2 my-2" href="#">
                        <img class="occasionImg m-auto mb-2" src="{{ asset('images/birthday-cake.png') }}" alt="">
                        Birthday Gift
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="occasion p-2 my-2" href="#">
                        <img class="occasionImg m-auto mb-2" src="{{ asset('images/delivery.png') }}" alt="">
                        Delivery Gifts
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="occasion p-2 my-2" href="#">
                        <img class="occasionImg m-auto mb-2" src="{{ asset('images/engagement-ring.png') }}" alt="">
                        Wedding Gifts
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="occasion p-2 my-2" href="#">
                        <img class="occasionImg m-auto mb-2" src="{{ asset('images/dollar.png') }}" alt="">
                        Under $5
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="occasion p-2 my-2" href="#">
                        <img class="occasionImg m-auto mb-2" src="{{ asset('images/health.png') }}" alt="">
                        Health Gifts
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--
    <div class="row mb-5">
        <h1>Need A Gift For?</h1>
        <div class="col d-flex">
            <div class="event me-3">
                <img class="img-thumbnail" src="https://via.placeholder.com/150"/>
                <div class="text-center">
                    <h5>Birthday</h5>
                </div>
            </div>
            <div class="event me-3">
                <img class="img-thumbnail" src="https://via.placeholder.com/150"/>
                <div class="text-center">
                    <h5>Wedding</h5>
                </div>
            </div>
            <div class="event me-3">
                <img class="img-thumbnail" src="https://via.placeholder.com/150"/>
                <div class="text-center">
                    <h5>Casual</h5>
                </div>
            </div>
            <div class="event me-3">
                <img class="img-thumbnail" src="https://via.placeholder.com/150"/>
                <div class="text-center">
                    <h5>Valentines</h5>
                </div>
            </div>
        </div>
    </div>
-->
    <div class="row">
        <h1>Our Featured Brands</h1>
        <div class="col d-flex" id="brandsContainer">
        
        </div>
    </div>
    <script type="module">
        import {Template} from '/adarna.js';

        const apiBaseUrl = '{{config("app")["api_base_url"]}}api/';
        const imgBaseUrl = '{{config("app")["api_base_url"]}}';

        const brandsContainer = document.querySelector('#brandsContainer');

        fetch(apiBaseUrl+'brands?'+ new URLSearchParams({
            status:'ACTV'
        })).then(response => { return response.json()}).then((reply)=>{
            
            if(!reply.status){
                alert('Unable to retrieve brands');
                return false;
            }

            const t = new Template();

            reply.data.map(brand=>{

                let card = t.div({ class:'card me-3 pointer-cursor', style:{width:'200px'} },()=>{
                    t.img({
                        src: imgBaseUrl+'storage/photos/brand/200px/'+brand.photo['200px'],
                        class:'card-img-top'
                    });
                    
                    t.div({class:'card-body text-center'},()=>{
                        t.h5({class:'card-title'},brand.name);
                    });
                });

                card.onclick = (e)=>{
                    document.location.href = '/brand/'+window.util.spaceToDash(brand.name);
                }

                brandsContainer.append(card);
            });
        }).catch((e)=>{
            console.log('here',e);
        });
    </script>
</div>
@endsection

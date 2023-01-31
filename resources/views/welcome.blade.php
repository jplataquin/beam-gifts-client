@extends('layouts.app')

@section('content')


  <!-- Hero Section -->

  <section class="hero">
    <div class="custom-container">
        <div class="row align-items-center">


            <div class="col-md-6">
                <img class="heroBanner" src="{{asset('images/banner-image.png')}}" alt="" width="100%">
                <img class="heroLogo" src="{{ asset('images/logo.png') }}" alt="" width="100%">
            </div>
            <div class="col-md-6 py-5">

                <h1 class="heroT">Beam a gift<br>to Iloilo</h1>
                <p class="heroD">Let your love ones feel the beam</p>
                <div class="text-end">
                    <button onclick="document.location.href='/gifts'" class="button gift-btn mt-2">Beam One Now</button>
                </div>
            </div>
            
            
        </div>
    </div>
</section>


<div class="container">
    


    <section class="topBrands py-5 py-5">
        <h3>Featured Brands</h3>
        <div class="container">
            <div class="row" id="brandsContainer">
                
            </div>
    </section>


 <!-- Ocassions -->
    <section class="occasions py-5">
        <h3>Gift Category</h3>
        <div class="container">
            <div class="row">

                @foreach( config('item_categories.options') as $key=>$text)
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="occasion p-2 my-2" href="/weh">
                        
                        <img class="occasionImg m-auto mb-2" src="{{ asset( 'images/icons/'.$key.'.png' ) }}" alt="">
                        {{$text}}
                        
                    </div>
                </div>
                @endforeach
                <!--
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
                    -->
            </div>
        </div>
    </section>


     <!-- Categories -->

     <section class="categories py-5">
        <h3>Brand Category</h3>
        <div class="container">

            <div class="row mt-3 category-row">
            @foreach( config('brand_categories.options') as $key=>$text)
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="occasion p-2 my-2" href="/weh">
                        
                        <img class="occasionImg m-auto mb-2" src="{{ asset( 'images/icons/'.$key.'.png' ) }}" alt="">
                        {{$text}}
                        
                    </div>
                </div>
                @endforeach
            </div>
            <!--
            <div class="row">
                <div class="col-12">
                    <div class="title-cont">
                        <h2 class="title">Our Categories</h2>
                        <div class="title-bg"></div>
                    </div>
                </div>
            </div>
            -->

            <!--
            <div class="row mt-3 category-row">
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <a href="#">
                        <img class="categoryImg mb-2" src="{{ asset('images/placeholder.png') }}" alt=""  >
                        <h3 class="categoryN">Category 1</h3>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <a href="#">
                        <img class="categoryImg mb-2" src="{{ asset('images/placeholder.png') }}" alt=""  >
                        <h3 class="categoryN">Category 2</h3>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <a href="#">
                        <img class="categoryImg mb-2" src="{{ asset('images/placeholder.png') }}" alt=""  >
                        <h3 class="categoryN">Category 3</h3>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <a href="#">
                        <img class="categoryImg mb-2" src="{{ asset('images/placeholder.png') }}" alt=""  >
                        <h3 class="categoryN">Category 4</h3>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <a href="#">
                        <img class="categoryImg mb-2" src="{{ asset('images/placeholder.png') }}" alt=""  >
                        <h3 class="categoryN">Category 5</h3>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <a href="#">
                        <img class="categoryImg mb-2" src="{{ asset('images/placeholder.png') }}" alt=""  >
                        <h3 class="categoryN">Category 6</h3>
                    </a>
                </div>
            </div>
                -->
        </div>
    </section>


    <script type="module">
        import {Template} from '/adarna.js';

        const apiBaseUrl = '{{config("app")["api_base_url"]}}api/';
        const imgBaseUrl = '{{config("app")["api_base_url"]}}';

        const brandsContainer = document.querySelector('#brandsContainer');

        fetch('/api/brand_list?'+ new URLSearchParams({
            status:'ACTV',
            order: 'RAND',
            limit:5
        })).then(response => { return response.json()}).then((reply)=>{
            
            if(!reply.status){
                alert('Unable to retrieve brands');
                return false;
            }

            const t = new Template();

            reply.data.map(brand =>{

                let card = t.div( {class:'col-lg-2 col-md-4 col-6 text-center'},()=>{
                   
               
                    t.a({href:'/brand/'+window.util.spaceToDash(brand.name)},()=>{
                        t.img({
                            src: imgBaseUrl+'storage/photos/brand/200px/'+brand.photo['200px'],
                            class:'occasionImg mb-2'
                        });
                        
                        t.h3({class:'categoryN'},brand.name);
                        
                    });
             

                });

            
                brandsContainer.append(card);
            });
             
            
            brandsContainer.append(
                t.div( {class:'col-lg-2 col-md-4 col-6 text-center'},()=>{
                    t.a({href:'/brands'},()=>{
                        t.img({
                            src: 'https://via.placeholder.com/200',
                            class:'occasionImg mb-2'
                        });
                        
                        t.h3({class:'categoryN'},'Show More');
                    
                    })
                })
            );

        }).catch((e)=>{
            console.log('here',e);
        });
    </script>
</div>
@endsection

@extends('layouts.app')

@section('content')


  <!-- Hero Section -->

  <section class="hero">
    <div class="custom-container">
        <div class="row align-items-center">


            <div class="col-md-6">
                <img class="heroBanner" src="{{asset('images/banner-image.png')}}" alt="" width="100%">
                <!-- <img class="heroLogo" src="{{ asset('images/logo.png') }}" alt="" width="100%"> -->
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

    <div class="row mt-3">
        <div class="form-group">
            <input type="text" class="form-control"/>
        </div>
    </div>


    <section class="topBrands py-5 py-5">
        <h3>Featured Brands</h3>
            <div class="row" id="brandsContainer"></div>
    </section>


 <!-- Ocassions -->
    <section class="tiles py-5">
        <h3>Categories</h3>
        
        <div class="container">
            <div class="row">

                @foreach( config('item_categories.options') as $key=>$text)
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="clickable-link tile p-2 my-2" data-href="/gifts/{{preg_replace('/[[:space:]]+/', '-', strtolower($text));}}">
                        
                        <img class="tileImg m-auto mb-2"  src="{{ asset( 'images/icons/'.$key.'.png' ) }}" alt="">
                        <div class="tileText">
                            {{$text}}
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>

</div>
     <!-- Categories -->
    <!--
     <section class="categories py-5">
        <h3>Brand Category</h3>
        <div class="container">

            <div class="row mt-3 category-row">
            @foreach( config('brand_categories.options') as $key=>$text)
                <div class="col-lg-2 col-md-4 col-6 text-center">
                    <div class="clickable-link tile p-2 my-2"  data-href="/brands/{{preg_replace('/[[:space:]]+/', '-', strtolower($text));}}">
                        
                        <img class="tileImg m-auto mb-2" src="{{ asset( 'images/icons/'.$key.'.png' ) }}" alt="">
                        <div class="tileText">
                            {{$text}}
                        </div>
                        
                    </div>
                </div>
            @endforeach
            </div>
           
        </div>
    </section>
-->

    <script type="module">
        import {Template,$q} from '/adarna.js';

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
                            class:'tileImg mb-2'
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
                            class:'tileImg mb-2'
                        });
                        
                        t.h3({class:'categoryN'},'Show More');
                    
                    })
                })
            );

        }).catch((e)=>{
            console.log('error',e);
        });

        $q('.clickable-link').apply((el)=>{

            el.onclick = (e)=>{
                let href = el.getAttribute('data-href');

                document.location.href = href;
            }
        });

    </script>
</div>
@endsection

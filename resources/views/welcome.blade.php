@extends('layouts.app')

@section('content')
<div class="container">
    
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

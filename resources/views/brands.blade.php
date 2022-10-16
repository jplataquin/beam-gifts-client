@extends('layouts.app')

@section('content')

<div id="brand_list"></div>
<button class="btn btn-primary" id="showMore">Show More</button>
<script type="module">
    import {Template} from '/adarna.js';

    const brandListEl = document.querySelector('#brand_list');
    const showMoreBtn = document.querySelector('#showMore');
    
    let page = 1;

    function getList(){
        window.util.$get('/api/brand_list',{
            'page' : page
        }).then(reply => {
            console.log(reply);
            page++;
        }).catch(err=>{
            alert('Opps something went wrong');
        });
    }

    showMoreBtn.onclick = (e)=>{
        e.preventDefault();

        getList();
    }

    getList();
</script>

@endsection
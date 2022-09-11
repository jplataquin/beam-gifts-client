@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>My Orders</h1>

        <div id="list">
        </div>
    </div>

    <script type="module">
        import {Template} from '/adarna.js';

        const list = document.querySelector('#list');

        window.util.$get('/api/myorders',{
            page: 1,
            limit: 10
        }).then(reply=>{
            console.log(reply);
        }).catch(e=>{
            alert('Something went wrong');
        });
    </script>
@endsection
@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>My Orders</h1>

        <div id="list">
        </div>
        <button id="showMoreBtn" class="btn btn-full btn-primary">Show More</button>
    </div>

    <script type="module">
        import {Template} from '/adarna.js';

        let page            = 0;
        const listEl        = document.querySelector('#list');
        const showMoreBtn   = document.querySelector('#showMoreBtn');   
        const t             = new Template();

        function list(){
            window.util.$get('/api/myorders',{
                page: page,
                limit: 5
            }).then(reply=>{

                if(!reply.status){
                    alert(reply.message);
                }
                
                if(!reply.data.orders.length){
                    showMoreBtn.style.display = 'none';
                }

                reply.data.orders.map(item=>{

                    let el = t.div({class:'card mb-3'},()=>{
                        t.div({class:'card-header'},'Order Ref: '+item.id);
                        t.div({class:'card-body'},()=>{
                            t.div({class:'card-title'},'');
                            t.h5({},'Status: '+item.status);
                            t.a({class:'btn btn-primary', href:'/myorders/'+item.uid },'View');
                        });

                    });

                    listEl.appendChild(el);
                });
                
                page++;


            }).catch(e=>{
                alert('Something went wrong');
            });
        }

        list();

        showMoreBtn.onclick = (e)=>{
            e.preventDefault();
            list();
        }


    </script>
@endsection
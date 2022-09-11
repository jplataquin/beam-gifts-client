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

        let page            = 1;
        const listEl        = document.querySelector('#list');
        const showMoreBtn   = document.querySelector('#showMoreBtn');   
        const t             = new Template();

        function list(){
            window.util.$get('/api/myorders',{
                page: page,
                limit: 10
            }).then(reply=>{

                if(!reply.status){
                    alert(reply.message);
                }
                
                reply.data.orders.map(item=>{

                    let el = t.div({class:'border border-parimary mb-3'},()=>{
                        t.label(item.created_at);
                        t.div(()=>{
                            t.label('Order ref: '+item.uid);
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
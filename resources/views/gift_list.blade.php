@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>My Gifts</h1>

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
            window.util.$get('/api/mygifts',{
                page: page,
                limit: 5
            }).then(reply=>{

                if(!reply.status){
                    alert(reply.message);
                }
                
                if(!reply.data.items.length){
                    showMoreBtn.style.display = 'none';
                }

               
                reply.data.items.map(item=>{

                    let el = t.div({
                        class:'card',
                        style:{width: '18rem'}
                    },()=>{
                        t.img({
                            class:'card-img-top', 
                            src:'https://via.placeholder.com/300.jpg?text=TEST'
                        });

                        t.div({
                            class:'card-body'
                        },()=>{
                            t.h5({class:'card-title'},item.item_name);
                            t.p({class:'card-text'},item.description);
                            t.a({href:'#',class:'btn btn-primary'},'View');
                        });
                    });

                    listEl.appendChild(el);
                });
                
                page++;


            }).catch(e=>{
                console.log(e);
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
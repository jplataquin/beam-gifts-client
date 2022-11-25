@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>My Orders</h1>

        <div id="list">
        </div>
        <button id="showMoreBtn" class="btn btn-full btn-primary">Show More</button>
    </div>

    <script type="module">
        import {Template,util} from '/adarna.js';
        console.log(util);
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
                            t.div({class:'card-title'},()=>{
                                t.txt('Status: '+item.status);
                            });
                            t.div({class:'row'},()=>{
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Total: ');
                                    t.txt( ''+util.numFormat.money('PHP',item.amount) );
                                });
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Payment Method: ');
                                    t.txt(item.payment_method);
                                });
                            });

                            t.div({class:'row'},()=>{
                                t.div({class:'col-lg-12 text-end'},()=>{
                                    t.a({class:'btn btn-primary', href:'/myorders/'+item.uid },'View');
                                });
                            });
                           
                        });

                    });

                    listEl.appendChild(el);
                });
                
                page++;


            }).catch(err=>{
                console.log(err);
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
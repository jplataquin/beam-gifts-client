@extends('layouts.app')

@section('content')
<!--
    <div class="container">
        <h1>My Gifts</h1>

        <div class="row">
            <div class="col form-group">
                <label>Status</label>
                <select id="status" class="form-control">
                    <option value=""> - </option>
                    <option value="AVLB">Available</option>
                    <option value="CLMD">Claimed</option>
                    <option value="EXPR">Expired</option>
                </select>
            </div>
            <div class="col form-group">
                <label>Brand</label>
                <input type="text" id="brand" class="form-control"/>
            </div>
        </div>
-->
    <div class="container mt-3 mb-5">
        <h1>My Gifts</h1>
        <hr>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select id="status" class="form-control">
                            <option value=""> - </option>
                            <option value="AVLB">Available</option>
                            <option value="CLMD">Claimed</option>
                            <option value="EXPR">Expired</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" id="brand" class="form-control"/>
                    </div>
                </div>
            </div>
        <hr>
        <div id="list" class="d-flex justify-content-around flex-wrap"></div>
        <button id="showMoreBtn" class="btn btn-full btn-primary">Show More</button>
    </div>

    <script type="module">
        import {Template} from '/adarna.js';

        let page            = 0;
        const listEl        = document.querySelector('#list');
        const showMoreBtn   = document.querySelector('#showMoreBtn');   
        const status        = document.querySelector('#status');
        const brand         = document.querySelector('#brand');
        
        const t             = new Template();

        function list(){
            window.util.$get('/api/mygifts',{
                page: page,
                limit: 5,
                status: status.value,
                brand: brand.value
            }).then(reply=>{

                if(!reply.status){
                    alert(reply.message);
                }
                
                if(!reply.data.items.length){
                    showMoreBtn.style.display = 'none';
                }

               
                reply.data.items.map(item=>{
                    console.log(item);
                    let el = t.div({
                        class:'card mb-3',
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
                            t.p({class:'card-text'},()=>{
                                t.txt(window.options.giftStatus[item.status].text);
                                t.br();
                                t.txt('🎁 '+item.consumed+' / '+item.quantity);
                                t.br();
                                t.txt(item.brand_name);
                                t.br();
                                t.txt('Expiry: '+item.expires_at);
                            });
                            t.div(()=>{
                                t.a({href:'#',class:'btn btn-secondary'},'Logs'); 
                                    t.a({href:'#',class:'btn btn-warning ms-2 me-2'},'Copy Link'); 
                                    t.a({href:'#',class:'btn btn-primary'},'View');
                                });
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

        status.onchange = (e)=>{
            e.preventDefault();
            listEl.innerHTML = '';
            page = 0;
            list();
        }

        brand.onkeyup = (e)=>{
            
            if(brand.value.length >= 3){
                listEl.innerHTML = '';
                page = 0;
                list();
            }
            
        }

        showMoreBtn.onclick = (e)=>{
            e.preventDefault();
          
            list();
        }


    </script>
@endsection
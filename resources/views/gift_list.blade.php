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
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Filter By</label>
                        <select id="filterBy" class="form-control">
                            <option value=""> - </option>
                            <option value="1">Expiry - Ascending</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" id="brand" class="form-control"/>
                    </div>
                </div>
            </div>
        <hr>
        <div id="list" class="d-flex justify-content-around flex-wrap"></div>
        <button id="showMoreBtn" class="btn btn-full btn-primary w-100">Show More</button>
    </div>

    <script type="module">
        import {Template,util,$q} from '/adarna.js';

        let page            = 0;
        const listEl        = $q('#list').first();
        const showMoreBtn   = $q('#showMoreBtn').first();   
        const status        = $q('#status').first();
        const brand         = $q('#brand').first();
        const filterBy      = $q('#filterBy').first();
        const t             = new Template();

        function list(){
            
            window.FreezeUI();

            let params = {
                page: page,
                limit: 8,
                status: status.value,
                brand: brand.value
            };

            let filter = filterBy.value;

            if(filter == 1){
                params.order_by = 'expires_at';
                params.order    = 'asc';
            }

            window.util.$get('/api/mygifts',params).then(reply=>{

                window.UnFreezeUI();

                if(!reply.status){
                    alert(reply.message);
                }
                
                if(!reply.data.items.length){
                    showMoreBtn.style.display = 'none';
                }

               
                reply.data.items.map(item=>{
                    console.log(item.photo);
                    let el = t.div({
                        class:'card mb-3',
                        style:{width: '18rem'}
                    },()=>{
                        t.img({
                            class:'card-img-top', 
                            src:"{{config('app')['api_base_url']}}storage/photos/item/200px/"+item.photo['200px']//'https://via.placeholder.com/300.jpg?text=TEST'
                        });

                        t.div({
                            class:'card-body'
                        },()=>{
                            t.h5({class:'card-title'},item.item_name);
                            t.strong(item.brand_name);
                            t.p({class:'card-text'},()=>{
                                t.txt(window.options.giftStatus[item.status].text);
                                t.br();
                                t.txt('🎁 '+item.consumed+' / '+item.quantity);
                              
                                t.br();

                                let exp_arr = item.expires_at.split(' ')[0].split('-');

                                let d = util.dateTime({
                                    year: exp_arr[0],
                                    month: exp_arr[1],
                                    date: exp_arr[2]
                                });
                               
                                t.txt('Expiry: '+d.month().short+' '+d.dd()+', '+d.yyyy());
                                t.br();
                                item.oid = item.oid+'';
                                t.txt('Order Ref: '+item.oid.padStart(6,0));
                            });

                            t.div({class:'text-center'},()=>{
                                t.a({href:'#',class:'btn btn-secondary'},'Logs'); 
                                t.a({href:'#',class:'btn btn-warning ms-2 me-2'},'Copy Link').onclick = (e)=>{
                                    e.preventDefault();

                                    navigator.clipboard.writeText(url).then(() => {
                                        window.toastCenter('Link Copied');
                                    }).catch(err=>{
                                        alert(err.message);
                                    });
                                }; 

                                t.a({href:'/gift/qr/'+item.uid+'/'+item.item_uid, target:'_blank',class:'btn btn-primary'},'Open');
                            });
                        });
                          
                    });

                    listEl.appendChild(el);
                });
                
                page++;


            });
        }

        list();

        status.onchange = (e)=>{
            e.preventDefault();
            listEl.innerHTML = '';
            page = 0;
            list();
        }


        filterBy.onchange = (e)=>{
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
@extends('layouts.app')

@section('content')

    <div class="container mt-3 mb-5">
        <h1>My Orders</h1>
        <hr>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Ordered By</label>
                        <select id="orderBy" class="form-control">
                            <option value="desc">Date Created - Descending</option>
                            <option value="asc">Date Created - Ascending</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Filter By</label>
                        <select id="filterBy" class="form-control">
                            <option value="">Status - All</option>
                            <option value="PAID">Status - Paid</option>
                            <option value="PEND">Status - Pending</option>
                        </select>
                    </div>
                </div>
            </div>
        <hr>
        <div id="list"></div>
    
        <button id="showMoreBtn" class="btn btn-full btn-primary w-100">Show More</button>
    </div>

    <script type="module">
        import {Template,util,$q} from '/adarna.js';
        
        let page            = 0;
        const listEl        = document.querySelector('#list');
        const showMoreBtn   = document.querySelector('#showMoreBtn');   
        const orderBy       = $q('#orderBy').first();
        const filterBy      = $q('#filterBy').first();
        const t             = new Template();

        const statusOpt = {
            'PEND': {
                text:'Pending',
                color:'#ebc034'
            },
            'PAID': {
                text:'Paid',
                color:'#1b702d'
            }
        };

        const paymentMethodOpt = {
            'cc':'Credit Card',
            'gc':'Gcash'
        };

        function list(){
            window.util.$get('/api/myorders',{
                page: page,
                limit: 5,
                date_created_order: orderBy.value,
                status: filterBy.value
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
                                t.h3('Status: ',()=>{
                                    
                                    t.span({style:{
                                        color:statusOpt[item.status].color
                                    }},statusOpt[item.status].text);
                                   
                                });
                            });

                            t.div({class:'row'},()=>{
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Total: ');
                                    t.txt( ''+util.numFormat.money('PHP',item.amount) );
                                });
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Payment Method: ');
                                    t.txt(paymentMethodOpt[item.payment_method]);
                                });
                            });

                            t.div({class:'row'},()=>{
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Date Created: ');

                                    let dateArr = item.created_at.split('.')[0].split('T');
                                    let dt = dateArr[0].split('-');
                                    let tm = dateArr[1].split(':');

                                    let d = util.dateTime(dt[0],dt[1],dt[2],tm[0],tm[1],tm[2]);

                                    t.txt( d.month().short+' '+d.dd()+', '+d.yyyy()+' '+d.time24hrs() );
                                });
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Date Paid: ');
                                    
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

        orderBy.onchange = (e)=>{
            page = 0;
            listEl.innerHTML = '';
            showMoreBtn.style.display = 'block';
            list();
        }

        filterBy.onchange = (e)=>{
            page = 0;
            listEl.innerHTML = '';
            showMoreBtn.style.display = 'block';
            list();
        }

        showMoreBtn.onclick = (e)=>{
            e.preventDefault();
            list();
        }


    </script>
@endsection
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
                    
                    console.log(item);
                    
                    let el = t.div({class:'card mb-3'},()=>{
                        let id = item.id+'';

                        t.div({class:'card-header'},'Order Ref: '+id.padStart(6,0));
                        t.div({class:'card-body'},()=>{
                            
                            t.div({class:'card-title'},()=>{
                                t.h3('Status: ',()=>{
                                    
                                    t.span({
                                        style:
                                        {
                                            color: window.options.orderStatus[item.status].color
                                        }
                                    },
                                        window.options.orderStatus[item.status].text
                                    );
                                   
                                });
                            });

                            t.div({class:'row'},()=>{
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Total: ');
                                    t.txt( ''+util.numFormat.money('PHP',item.calculation.grand_total) );
                                });
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Payment Method: ');
                                    t.txt(window.options.paymentMethod[item.payment_method].text);
                                });
                            });

                            t.div({class:'row'},()=>{
                                t.div({class:'col-lg-6'},()=>{
                                    t.strong('Date Created: ');

                                    let dateArr = item.created_at.split('.')[0].split('T');
                                    let dt = dateArr[0].split('-');
                                    let tm = dateArr[1].split(':');

                                    let d = util.dateTime({
                                        year:dt[0],
                                        month:dt[1],
                                        date:dt[2],
                                        hour:tm[0],
                                        min:tm[1],
                                        sec:tm[2]
                                    });

                                    t.txt( d.month().short+' '+d.dd()+', '+d.yyyy()+' '+d.time24hrs() );
                                });
                                t.div({class:'col-lg-6'},()=>{
                                   
                                    if(item.status == 'PEND'){
                                        t.strong('Expires in: ');
                                        t.txt('24 hours');
                                    }
                                    
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
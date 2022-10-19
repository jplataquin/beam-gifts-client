@extends('layouts.app')

@section('content')

<section class="topBrands py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-cont">
                        <h2 class="title">Gifts</h2>
                        <div class="title-bg"></div>
                    </div>
                    <div class="subTitle">What would you like to gift?</div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-2 col-md-3 filter-column">
                    <ul class="nav nav-pills fltCont mb-3" id="tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="fltItem active" data-bs-toggle="pill" data-value="" type="button" role="tab" aria-controls="filter-all" aria-selected="true">All</button>
                        </li>


                        @foreach(config('item_categories')['options'] as $val=>$txt)
                            <li class="nav-item" role="presentation">
                                <button class="fltItem" data-bs-toggle="pill" data-value="{{$val}}" type="button" role="tab" aria-controls="filter-{{$val}}" aria-selected="true">{{$txt}}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-10 col-md-9">
                    <div class="tab-content" id="filter-tabContent">
                        <div class="tab-pane fade show active" id="filter-all" role="tabpanel" aria-labelledby="filter-all-tab" tabindex="0">
                            <div class="row" id="item_list">
                                <!--
                                <div class="col-3 text-center">
                                    <h2 id="brandtype" class="brandtype">All</h2>
                                 <p class="totals">Total 15</p> 
                                </div>
                                -->
                                <div class="col-12 text-start">
                                    <input id="query" type="text" class="form-control" placeholder="Search Gift"/>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12 d-grid">
                                    <button class="btn btn-primary" id="showMore">Show More</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

      
    </section>



<script type="module">
    import {Template} from '/adarna.js';

    const brandListEl = document.querySelector('#item_list');
    const showMoreBtn = document.querySelector('#showMore');
    const queryEl     = document.querySelector('#query');

    const imgBaseUrl = '{{config("app")["api_base_url"]}}';
    const t = new Template();

    let page        = 1;
    let category    = '';
    let query       = '';

    queryEl.onkeyup = (e)=>{
    
        if(e.keyCode == 13){
            page  = 1;
            query = queryEl.value;
            category = '';
            showMoreBtn.style.display = 'block';
            clearList();
            getList();
        }
    }

    Array.from(document.querySelectorAll('.fltItem')).map(filter => {

        filter.onclick = (e)=>{
            page            = 1;
            category        = filter.getAttribute('data-value');
            queryEl.value   = '';
            query           = '';
            showMoreBtn.style.display = 'block';
            clearList();
            getList();
        }
    });

    function clearList(){
        Array.from(document.querySelectorAll('.brand-item')).map(item => {
            item.remove();
        });
    }

    function getList(){

        showMoreBtn.disabled = true;

        window.util.$get('/api/item_list',{
            page        : page,
            category    : category,
            query       : query
        }).then(reply => {
            
            showMoreBtn.disabled = false;
        
            if(!reply.status){
                alert(reply.message);
                return false;
            }

            if(!reply.data.length){
                showMoreBtn.style.display = 'none';
                return false;
            }

            reply.data.map(item=>{

                let col = t.div({class:"gift-item col-lg-4 col-md-6 col-12 my-2"},()=>{
                    t.div({class:"popBrandsbox"},()=>{
                        t.img({src: imgBaseUrl+'storage/photos/item/200px/'+item.photo['200px'],alt:"",class:"popItembigImg"});
                        t.div({class:"popbrandinfo"},()=>{
                            t.img({src: imgBaseUrl+'storage/photos/brand/150px/'+item.photo['150px'],alt:"",class:"popbrandimg"});
                            t.h3({class:"popbrandT"},item.name);
                        });
                    });
                });

                col.onclick = ()=>{
                    document.location.href = '/gift/'+window.util.spaceToDash(item.name);
                }

                brandListEl.appendChild(col);

            });

            page++;
        }).catch(err=>{
            alert('Opps something went wrong');
            showMoreBtn.disabled = false;
        
        });
    }

    showMoreBtn.onclick = (e)=>{
        e.preventDefault();

        getList();
    }

    getList();
</script>

@endsection
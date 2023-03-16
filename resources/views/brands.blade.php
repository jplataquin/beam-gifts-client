@extends('layouts.app')

@section('content')

<section class="topBrands py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-cont">
                        <h2 class="title">Brands</h2>
                        <div class="title-bg"></div>
                    </div>
                    <div class="subTitle">See our partners ❤️</div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-2 col-md-3 filter-column">
                    <ul class="nav nav-pills fltCont mb-3" id="tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="fltItem active" data-bs-toggle="pill" data-value="" type="button" role="tab" aria-controls="filter-all" aria-selected="true">All</button>
                        </li>


                        @foreach(config('brand_categories')['options'] as $val=>$txt)
                            <li class="nav-item" role="presentation">
                                <button class="fltItem" data-bs-toggle="pill" data-value="{{$val}}" type="button" role="tab" aria-controls="filter-{{$val}}" aria-selected="true">{{$txt}}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-10 col-md-9">
                    <div class="tab-content" id="filter-tabContent">
                        <div class="tab-pane fade show active" id="filter-all" role="tabpanel" aria-labelledby="filter-all-tab" tabindex="0">
                            <div class="row" id="brand_list">
                                <!--
                                <div class="col-3 text-center">
                                    <h2 id="brandtype" class="brandtype">All</h2>
                                 <p class="totals">Total 15</p> 
                                </div>
                                -->

                                
                                <div class="col-12 text-start">

                                <div class="col-12 text-start" style="z-index:-2">
                                    <div class="input-group"> 
                                        <span class="input-group-text">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.1" d="M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" fill="#323232"/>
                                                <path d="M15 15L21 21" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="#323232" stroke-width="2"/>
                                            </svg>
                                        </span>
                                        <input id="query" type="text" class="form-control" placeholder="Search Brand"/>
                                    </div>
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
    import {Template,$q} from '/adarna.js';

    const brandListEl = document.querySelector('#brand_list');
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

        window.util.$get('/api/brand_list',{
            page      : page,
            category : category,
            query: query
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

                let col = t.div({class:"brand-item col-lg-4 col-md-6 col-12 my-2"},()=>{
                    t.div({class:"popBrandsbox"},()=>{
                        t.img({src: imgBaseUrl+'storage/photos/brand/banner/'+item.photo['banner'],alt:"",class:"popBrandbigImg"});
                        t.div({class:"popbrandinfo"},()=>{
                            t.img({src: imgBaseUrl+'storage/photos/brand/150px/'+item.photo['150px'],alt:"",class:"popbrandimg"});
                            t.h3({class:"popbrandT"},item.name);
                        });
                    });
                });

                col.onclick = ()=>{
                    document.location.href = '/brand/'+window.util.spaceToDash(item.name);
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

    //If filter category was preselected
    let option = '{{$option}}';

    if(option != ''){

        
        let filterButton = $q('.fltItem[data-value="'+option+'"]').first();
    
        if(filterButton){
            filterButton.click();
        }

    }else{
        getList();
    }
</script>

@endsection
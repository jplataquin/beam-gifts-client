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
                    <div class="subTitle">What would you like to gift?</div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-2 col-md-3 filter-column">
                    <ul class="nav nav-pills fltCont mb-3" id="tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="fltItem active" id="filter-all-tab" data-bs-toggle="pill" data-bs-target="#filter-all" type="button" role="tab" aria-controls="filter-all" aria-selected="true">All</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="fltItem" id="filter-drinks-tab" data-bs-toggle="pill" data-bs-target="#filter-drinks" type="button" role="tab" aria-controls="filter-drinks" aria-selected="true">Brand Type 1</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="fltItem" id="filter-ltNight-tab" data-bs-toggle="pill" data-bs-target="#filter-ltNight" type="button" role="tab" aria-controls="filter-ltNight" aria-selected="false">Brand Type 2</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="fltItem" id="filter-desserts-tab" data-bs-toggle="pill" data-bs-target="#filter-desserts" type="button" role="tab" aria-controls="filter-desserts" aria-selected="false">Brand Type 3</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="fltItem" id="filter-shopping-tab" data-bs-toggle="pill" data-bs-target="#filter-shopping" type="button" role="tab" aria-controls="filter-shopping" aria-selected="false">Brand Type 4</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="fltItem" id="filter-delivery-tab" data-bs-toggle="pill" data-bs-target="#filter-delivery" type="button" role="tab" aria-controls="filter-delivery" aria-selected="false">Brand Type 5</button>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-10 col-md-9">
                    <div class="tab-content" id="filter-tabContent">
                        <div class="tab-pane fade show active" id="filter-all" role="tabpanel" aria-labelledby="filter-all-tab" tabindex="0">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="brandtype">All</h2>
                                    <p class="totals">Total 15</p>
                                </div>

                                <section id="brand_list">
                                </section>
                                <!--
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 2</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 3</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 4</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 5</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 6</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 7</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 8</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 9</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 10</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 11</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 12</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 13</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 14</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 15</h3>
                                        </div>
                                    </div>
                                </div>

                                -->
                            </div>

                        </div>
                        <div class="tab-pane fade" id="filter-drinks" role="tabpanel" aria-labelledby="filter-drinks-tab" tabindex="0">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="brandtype">Brand Type 1</h2>
                                    <p class="totals">Total 3</p>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 1</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 2</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 3</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="filter-ltNight" role="tabpanel" aria-labelledby="filter-ltNight-tab" tabindex="0">
                            
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="brandtype">Brand Type 2</h2>
                                    <p class="totals">Total 3</p>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 4</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 5</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 6</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="filter-desserts" role="tabpanel" aria-labelledby="filter-desserts-tab" tabindex="0">
                            
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="brandtype">Brand Type 3</h2>
                                    <p class="totals">Total 3</p>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 7</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 8</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 9</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="filter-shopping" role="tabpanel" aria-labelledby="filter-shopping-tab" tabindex="0">
                            
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="brandtype">Brand Type 4</h2>
                                    <p class="totals">Total 3</p>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 10</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 11</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 12</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="filter-delivery" role="tabpanel" aria-labelledby="filter-delivery-tab" tabindex="0">
                            
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="brandtype">Brand Type 5</h2>
                                    <p class="totals">Total 3</p>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 13</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 14</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12 my-2">
                                    <div class="popBrandsbox">
                                        <img src="includes/images/placeholder.png" alt="" class="popBrandbigImg">
                                        <div class="popbrandinfo">
                                            <img src="includes/images/placeholder.png" alt="" class="popbrandimg">
                                            <h3 class="popbrandT">Brand 15</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<button class="btn btn-primary" id="showMore">Show More</button>
<script type="module">
    import {Template} from '/adarna.js';

    const brandListEl = document.querySelector('#brand_list');
    const showMoreBtn = document.querySelector('#showMore');
    
    const t = new Template();

    let page = 1;

    function getList(){
        window.util.$get('/api/brand_list',{
            'page' : page
        }).then(reply => {
            
            if(!reply.status){
                alert(reply.message);
                return false;
            }

            console.log(reply.data);

            reply.data.map(item=>{

                brandListEl.appendChild(
                    t.div({class:"col-lg-4 col-md-6 col-12 my-2"},()=>{
                        t.div({class:"popBrandsbox"},()=>{
                            t.img({src:"{{asset('images/placeholder.png')}}",alt:"",class:"popBrandbigImg"});
                            t.div({class:"popbrandinfo"},()=>{
                                t.img({src:"{{asset('images/placeholder.png')}}",alt:"",class:"popbrandimg"});
                                t.h3({class:"popbrandT"},item.namde);
                            });
                        });
                    })
                );

            });

            page++;
        }).catch(err=>{
            alert('Opps something went wrong');
        });
    }

    showMoreBtn.onclick = (e)=>{
        e.preventDefault();

        getList();
    }

    getList();
</script>

@endsection
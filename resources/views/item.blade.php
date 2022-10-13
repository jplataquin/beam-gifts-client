@extends('layouts.app')

@section('content')

<section class="breadcrumbs">

</section>

<section class="product-top py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$item->photo['400px']}}" alt="" class="product-img" width="100%">
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <h5 class="product-title">{{ $item->name }}</h5>
                    <p class="product-shortDESC">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <p class="product-price">Php {{$item->price}}</p>
                    <ul class="additional-info">
                        <li>Expires in {{$item->expiry}} days after purchase</li>
                        <li>Can be sent via link</li>
                    </ul>
                    <p class="product-notice"><strong>You can gift up to 5.</strong></p>
                    <select class="form-control" id="qty">
                        @for ($i = 1; $i<=5; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select> 
                    <div class="row mt-3">
                        <div class="col-12 d-flex align-items-center">
                            <button id="buyNowBtn" class="button px-5 py-2 mx-2">Buy Now</button>
                            <button id="addToCartBtn" class="button px-5 py-2">Add To Cart</button>
                        </div>
                    </div>
                    <div class="separator"></div>
                    <div class="brand-row d-flex align-items-center">
                        <img src="{{config('app')['api_base_url']}}storage/photos/brand/200px/{{$brand->photo['200px']}}" alt="{{$brand->name}}">
                        <a href="#" class="brandname ms-2">{{$brand->name}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="product-additionalInfo py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="rp-tab" data-bs-toggle="tab" data-bs-target="#rp-tab-pane" type="button" role="tab" aria-controls="rp-tab-pane" aria-selected="false">Refund & Policies</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                            <p class="product-desc">
                                - Must be used before the expiration and will not be valid for use once expired.

                                - The gift card can be redeemed for a gift certificate at the kiosk located in the department store (However it cannot be redeemed at kiosks located in EMART)

                                

                                [How to use kiosks]

                                1) Check the MMS barcode on mobile

                                2) Scan the barcode at kiosk and redeem it for actual certificate.

                                - The redeemed gift certificates can be used in affiliated stores.

                                

                                [Not Redeemable]

                                천안아산점

                                

                                ☎Galaxia Moneytree CX center : 1566-0123

                                (Mon~Fri, 9AM~6PM)
                            </p>
                        </div>
                        <div class="tab-pane fade" id="rp-tab-pane" role="tabpanel" aria-labelledby="rp-tab" tabindex="0">
                            <p class="product-desc">
                                - If gift card was deleted or not received, please contact SodaGift customer support.

                                [Cancel and Refund Policy]

                                - Buyer can request cancellation or refund of unused gift card.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script type="module">
    const addToCartBtn  = document.querySelector('#addToCartBtn');
    const buyNowBtn     = document.querySelector('#buyNowBtn');
    const qty           = document.querySelector('#qty');

    addToCartBtn.onclick = (e)=>{
        e.preventDefault();

        addToCartBtn.disabled = true;
        buyNowBtn.disabled = true;

        window.util.addToCart({
            id:'{{$item->id}}',
            qty: qty.value
        }).then(reply=>{

            addToCartBtn.disabled = false;
            buyNowBtn.disabled = false;

            if(reply.status <= 0){
                alert(reply.message);
                return;
            }

            alert('Item in cart');

        });
    }
</script>
@endsection

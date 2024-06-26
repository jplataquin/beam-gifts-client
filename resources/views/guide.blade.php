@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-3 ">Guide</h1>
    
    <div class="container mb-5">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <div class="text-center">
                    <h3>Step 1</h3>
                    <hr>        
                    <img src="https://placehold.co/600x400" class="d-block w-100" alt="...">
                    <div class="">
                        <h5>Select a gift from our collection</h5>
                        <p>You can filter the gifts by brands or item category.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item" data-bs-interval="2000">
                <div class="text-center">
                    <h3>Step 2</h3>
                    <hr>        
                    <img src="https://placehold.co/600x400" class="d-block w-100" alt="...">
                    <div class="">
                        <h5>Buy and Gift</h5>
                        <p>Checkout and pay for the gift item.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center">
                    <h3>Step 3</h3>
                    <hr>        
                    <img src="https://placehold.co/600x400" class="d-block w-100" alt="...">
                    <div class="">
                        <h5>Send the QR code or link to the reveiver.</h5>
                        <p>Surprise your loved ones by sending them the QR code or link, using any of your favorite messeging app.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center">
                    <h3>Step 4</h3>
                    <hr>        
                    <img src="https://placehold.co/600x400" class="d-block w-100" alt="...">
                    <div class="">
                        <h5>Receiver opens the QR code or link.</h5>
                        <p>Congratulations you have beamed a gift to your loved one.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center">
                    <h3>Step 5</h3>
                    <hr>        
                    <img src="https://placehold.co/600x400" class="d-block w-100" alt="...">
                    <div class="">
                        <h5>Receiver opens the QR code or link.</h5>
                        <p>Congratulations you have beamed a gift to your loved one.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center">
                    <h3>Step 6</h3>
                    <hr>        
                    <img src="https://placehold.co/600x400" class="d-block w-100" alt="...">
                    <div class="">
                        <h5>Proceed to the establishment to claim the gift.</h5>
                        <p>.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center">
                    <h3>Step 7</h3>
                    <hr>        
                    <img src="https://placehold.co/600x400" class="d-block w-100" alt="...">
                    <div class="">
                        <h5>Show the QR code or link to the establisment.</h5>
                        <p>.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="text-center">
                    <h3>Step 8</h3>
                    <hr>        
                    <img src="https://placehold.co/600x400" class="d-block w-100" alt="...">
                    <div class="">
                        <h5>Enjoy your gift.</h5>
                        <p>.</p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    </div>
</div>

<script type="module">
    import '/bootstrap.js';
    import {Template,$q} from '/adarna.js';

    const myCarouselElement = $q('#carouselExampleDark').first();

    const carousel = new bootstrap.Carousel(myCarouselElement, {});

</script>
@endsection
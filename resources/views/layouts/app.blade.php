<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!--
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    
    
    <!--
    <script async src="https://cdn.jsdelivr.net/npm/es-module-shims@1/dist/es-module-shims.min.js" crossorigin="anonymous"></script>
    <script type="importmap">
    {
      "imports": {
        "@popperjs/core": "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js",
        "bootstrap": "https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.esm.min.js"
      }
    }
    </script>
    -->

</head>
<body>

    <section class="header">
        <div class="topbar py-2">
            <div class="container">
                <div class="row">
                    <!-- Button trigger modal -->
                    <button type="button" class="lang-button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                       To: South Korea <img class="langImg" src="{{ asset('images/kr.png') }}" alt="">
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header border border-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="modalTitle mb-3">
                                       <strong>Where do you want to send your gift to?</strong>  
                                    </h5>
                                    <ul class="langList">
                                        <li class="lang">
                                            <a href="#"><img class="langImg" src="{{ asset('images/kr.png') }}" alt=""> South Korea</a>
                                        </li>
                                        <li class="lang">
                                            <a href="#"><img class="langImg" src="{{ asset('images/us.png') }}" alt=""> United States</a>
                                        </li>
                                        <li class="lang">
                                            <a href="#"><img class="langImg" src="{{ asset('images/ca.png') }}" alt=""> Canada</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="navigationbar py-3 d-lg-block d-none">
            <div class="header-row m-auto">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="lnav-col">
                        <img class="logo" src="{{ asset('images/logo.png') }}" alt="">
                        <ul class="dnavs">
                            <li><a href="#">Brands</a></li>
                            <li><a href="#">Categories</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <a href="#" class="src-btn"><img class="search-icon" src="{{ asset('images/search.png') }}" alt=""> Search gifts or brands</a>
                    </div>
                    
                    <div class="rnav-col">
                        <ul class="dnavs">
                            <li><a href="#">Help</a></li>
                            <li><a href="#">How to Use</a></li>
                            <li><a href="#" class="login-btn">Login</a></li>
                            <li><a href="#" class="button singup-btn">Sign Up</a></li>
                            <li> 
                                <div class="shopping-cart">
                                    <img class="cart-icon" src="{{ asset('images/cart.png') }}" alt="">
                                    <p class="cart-quantity">0</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="mobile-nav" class="mobile-navigation w-100 py-3 border-top d-lg-none">
            <div id="mobile-navBot-items" class="row justify-content-center">
                <div class="col-3 text-center">
                    <a href="#"><img src="{{ asset('images/home.png') }}" alt="" width="30px" height="30px"></a>
                </div>
                <div class="col-3 text-center">
                    <a href="#"><img src="{{ asset('images/search.png') }}" alt="" width="30px" height="30px"></a>
                </div>
                <div class="col-3 text-center">
                    <a href="#"><img src="{{ asset('images/user.png') }}" alt="" width="30px" height="30px"></a>
                </div>
                <div class="col-3 text-center">
                    <a href="#" onclick="openNav()" id="mobilenavHAM"><img src="{{ asset('images/ham.png') }}" alt="" width="30px" height="30px"></a>
                    <a href="#" onclick="closeNav()" id="mobilenavClose"><img src="{{ asset('images/close.png') }}" alt="" width="30px"></a>
                </div>
            </div>
        </div>        

        <div id="mobile-side" class="mobile-navSidebar border-start d-lg-none">
            <ul class="mobile-nav m-0 p-3 text-end">
                <li class="my-2">
                    <a href="#">Brands</a>
                </li>
                <li class="my-2">
                    <a href="#">Categories</a>
                </li>
                <li class="my-2">
                    <a href="#">Help</a>
                </li>
                <li class="my-2">
                    <a href="#">How to use</a>
                </li>
                <li class="my-2">
                    <a href="#">login</a>
                </li>
                <li class="my-2">
                    <a href="#"><button class="button">sign up</button></a>
                </li>
            </ul>
        </div>
    </section>

    
    
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>




     <!-- Footer -->

     <section class="footer pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12 my-3">
                    <ul class="footer-col">
                        <li><h4 class="footer-title">Brand Name</h4></li>
                        <li><a class="footer-item" href="#">About Us</a></li>
                        <li><a class="footer-item" href="#">Invite Friends</a></li>
                        <li><a class="footer-item" href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-12 my-3">
                    <ul class="footer-col">
                        <li><h4 class="footer-title">Send gifts to</h4></li>
                        <li><a class="footer-item" href="#"><img class="langImg" src="{{ asset('images/kr.png') }}" alt=""> South Korea</a></li>
                        <li><a class="footer-item" href="#"><img class="langImg" src="{{ asset('images/us.png') }}" alt=""> United States</a></li>
                        <li><a class="footer-item" href="#"><img class="langImg" src="{{ asset('images/ca.png') }}" alt=""> Canada</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-12 my-3">
                    <ul class="footer-col">
                        <li><h4 class="footer-title">Support</h4></li>
                        <li><a class="footer-item" href="#">Help</a></li>
                        <li><a class="footer-item" href="#">How to use</a></li>
                        <li><a class="footer-item" href="#">support@domain.com</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-12 my-3">
                    <ul class="footer-col">
                        <li><h4 class="footer-title">Follow us</h4></li>
                        <li><a class="footer-item" href="#"><img class="socialImg" src="{{ asset('images/facebook.png') }}" alt=""> Facebook</a></li>
                        <li><a class="footer-item" href="#"><img class="socialImg" src="{{ asset('images/instagram.png') }}" alt=""> Instagram</a></li>
                        <li><a class="footer-item" href="#"><img class="socialImg" src="{{ asset('images/youtube.png') }}" alt=""> Youtube</a></li>
                    </ul>
                </div>
                <div class="col-12">
                    <p class="copyright text-center mb-3 mt-5">© Company Name or its affiliates 2022</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>

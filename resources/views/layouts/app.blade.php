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
            &nbsp;
        </div>

        <div class="navigationbar py-3 d-lg-block d-none">
            <div class="header-row m-auto">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="lnav-col">
                       
                        <a class="topLogo" href="{{ url('/') }}">
                            <img class="logo" src="{{ asset('images/logo.png') }}" alt="">
                        </a>
                        
                        <ul class="dnavs">
                            <li><a href="/brands">Brands</a></li>
                            <li><a href="/gifts">Gifts</a></li>
                        </ul>
                    </div>
                    
                    <!--
                    <div>
                        <a href="#" class="src-btn"><img class="search-icon" src="{{ asset('images/search.png') }}" alt=""> Search gifts or brands</a>
                    </div>
                    -->

                    <div class="rnav-col">
                        <ul class="dnavs">
                            <li><a href="/faq">FAQ</a></li>
 
                        

                            @guest
                                @if (Route::has('login'))
                                    <li><a href="{{ route('login') }}" class="login-btn">{{ __('Login') }}</a></li>
                                @endif

                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}" class="button singup-btn">Sign Up</a></li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->nickname() }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        
                                        <a class="dropdown-item" href="/profile">Profile</a>
                                        <a class="dropdown-item" href="/myorders">My Orders</a>

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest

                            
                            
                            <li> 
                                <a href="/cart">
                                    <div class="shopping-cart">
                                            <img class="cart-icon" src="{{ asset('images/cart.png') }}" alt="">
                                            <p id="cart-quantity" class="cart-quantity">{{ count( \Cart::getContent()) }}</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="mobile-nav" class="mobile-navigation w-100 py-3 border-top d-lg-none">
          
            <div id="mobile-navBot-items" class="row justify-content-center">
                
                <div class="col-3 text-center">
                    <a href="/profile"><img src="{{ asset('images/user.png') }}" alt="" width="30px" height="30px"></a>
                </div>
                <div class="col-3 text-center">
                    <a href="/"><img src="{{ asset('images/home.png') }}" alt="" width="30px" height="30px"></a>
                </div>
                <div class="col-3 text-center">
                    <a href="/cart">
                        <div class="shopping-cart">
                                <img src="{{ asset('images/cart.png') }}" alt="" width="30px" height="30px">
                                <p style="right:17px" class="cart-quantity">{{count(\Cart::getContent())}}</p>
                        </div>
                    </a>
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
                    <a class="topLogo" href="{{ url('/') }}">
                        <img class="logo" src="{{ asset('images/logo.png') }}" alt="">
                    </a>
                </li>

                <li class="my-2">
                    <a href="/brands">Brands</a>
                </li>
                <li class="my-2">
                    <a href="/gifts">Gifts</a>
                </li>

                @guest
                
                    @if (Route::has('register'))
                        <li class="my-2">
                            <a href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endif
                    
                    @if (Route::has('login'))
                        <li class="my-2">
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                @else

                    <li class="my-2">
                        <a href="/myorders">My Orders</a>
                    </li>

                    <li class="my-2" style="margin-top:20px">
                       <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>
                @endguest
             
                
            </ul>
        </div>
    </section>

    
    
    <div id="app">
        <main>
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

    <script>
        function openNav() {
            document.getElementById("mobile-side").style.width = "200px";
            document.body.style.marginRight = "200px";
            document.getElementById("mobilenavHAM").style.display = "none";
            document.getElementById("mobilenavClose").style.display = "block";
        }
        function closeNav() {
            document.getElementById("mobile-side").style.width = "0px";
            document.body.style.marginRight = "0px";
            document.getElementById("mobilenavHAM").style.display = "block";
            document.getElementById("mobilenavClose").style.display = "none";
        }

    </script>
</body>
</html>

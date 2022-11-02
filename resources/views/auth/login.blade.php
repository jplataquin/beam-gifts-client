<!DOCTYPE html>
<html lang="en">
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

    <section class="login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 d-lg-block d-none login-leftCol">
                    <div class="row leftCol-row">
                        <div class="col-4">
                            <img src="{{asset('images/placeholder.png')}}" alt="" class="left-imgs">
                        </div>
                        <div class="col-4">
                            <img src="{{asset('images/placeholder.png')}}" alt="" class="left-imgs">
                        </div>
                        <div class="col-4">
                            <img src="{{asset('images/placeholder.png')}}" alt=""  class="left-imgs">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 p-3">
                    <div class="loghead">
                        <a href="/register" class="button">Signup</a>
                    </div>
                    <div class="text-center">
                        <img class="logo" src="{{ asset('images/logo.png') }}" alt="">
                    </div>
                    <div class="login-form pt-5 m-auto">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <input id="email" type="email" class="input-field my-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mail"/>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            

                            <input id="password" type="password" class="input-field my-3 @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <a href="/password/reset" class="frgPass">Forgot Password?</a>

                            <button type="submit" value="Login" class="mt-3 submitBTN">
                                {{ __('Login') }}
                            </button>

                        </form>
                    </div>

                    <div class="or mx-auto my-4">
                        <p class="text-center m-auto">or</p>
                    </div>

                    <div class="login-btns mx-auto">
                        <a href="#" class="btns google my-2">
                            <img src="{{asset('images/google.svg')}}" alt=""> Continue with Google</a>
                        <a href="#" class="btns facebook my-2"><img src="{{asset('images/facebook.svg')}}" alt=""> Continue with facebook</a>
                    </div>

                </div>
            </div>
        </div>
    </section>



</body>
</html>

<!--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

-->
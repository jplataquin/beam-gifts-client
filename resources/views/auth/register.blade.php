@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <img src="{{ asset('images/gift-1.png') }}" class="w-200" />
        </div>
    </div>
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-darkmagenta fontcolor-white text-center">{{ __('Welcome to Beam Gifts - Please Register Here') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="birthday" class="col-md-4 col-form-label text-md-end">{{ __('Birthday') }}</label>

                            <div class="col-md-6">
                                <select id="month" name="month">
                                    <option value="01" @if( old('month') == '01' ) selected @endif >Jan</option>
                                    <option value="02" @if( old('month') == '02' ) selected @endif >Feb</option>
                                    <option value="03" @if( old('month') == '03' ) selected @endif >Mar</option>
                                    <option value="04" @if( old('month') == '04' ) selected @endif >Apr</option>
                                    <option value="05" @if( old('month') == '05' ) selected @endif >May</option>
                                    <option value="06" @if( old('month') == '06' ) selected @endif >Jun</option>
                                    <option value="07" @if( old('month') == '07' ) selected @endif >Jul</option>
                                    <option value="08" @if( old('month') == '08' ) selected @endif >Aug</option>
                                    <option value="09" @if( old('month') == '09' ) selected @endif >Sep</option>
                                    <option value="10" @if( old('month') == '10' ) selected @endif >Oct</option>
                                    <option value="11" @if( old('month') == '11' ) selected @endif >Nov</option>
                                    <option value="12" @if( old('month') == '12' ) selected @endif >Dec</option>
                                </select>
                                -
                                <select id="date" name="date">
                                    @for($i=1;$i<=31;$i++)
                                    <option value="{{sprintf('%02d',$i)}}" @if( old('date') == sprintf('%02d',$i) ) selected @endif>{{sprintf("%02d",$i)}}</option>
                                    @endfor
                                </select>
                                -
                               <input id="year" placeholder="year" type="number" name="year" value="{{ old('year') }}" length="4" maxlength="4"/>

                               <input type="hidden" class="@error('birthday') is-invalid @enderror" id="birthday" value="{{ old('birthday') }}" name="birthday"/>
                                
                                @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                <!--
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('birthday') }}" required autocomplete="birthday" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                -->
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('Firstname') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname"/>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Lastname') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname"/>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Terms of Service</label>

                            <div class="col-md-6">
                                <div>
                                    <a href="/tos" target="__blank">Please Read</a>
                                    <div class="w-100 border border-primary" style="max-height:200px; overflow-y:scroll">
                                    @include('tos_content');
                                    </div>
                                </div>


                                Agree: <input id="" type="checkbox" class="" name="tos_agree" value="1" required/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">&nbsp</label>

                            <div class="col-md-6">
                                @if(config('services.recaptcha.key'))
                                    <div class="g-recaptcha"
                                        data-sitekey="{{config('services.recaptcha.key')}}">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 text-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="module">

    let month       = document.querySelector('#month');
    let date        = document.querySelector('#date');
    let year        = document.querySelector('#year');
    let birthday    = document.querySelector('#birthday');

    function setDate(){
        console.log(year.value+'-'+month.value+'-'+date.value);

        birthday.value = year.value+'-'+month.value+'-'+date.value;
    }

    month.onchange = (e)=>{
        e.preventDefault();
        setDate();
    }

    date.onchange = (e)=>{
        e.preventDefault();
        setDate();
    }

    year.onkeyup = (e)=>{
        e.preventDefault();
        setDate();
    }
</script>
@endsection

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
                <div class="card-header bg-darkmagenta fontcolor-white text-center">
                    <h3 class="fontcolor-white">Hello There!</h3>
                </div>
                <div class="card-body">
                    <div class="text-center">     
                        <h5>We sent a validation link to your E-mail</h5>
                    </div>

                    <div class="row">
                        <div class="col form-group">
                            <label>&nbsp;</label>
                            <input type="email" class="form-control text-center" value="{{$email}}"/>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col form-group text-center">
                            <label>Did not receive any email?</label>
                            &nbsp;
                            <button id="resend" class="btn btn-primary">Try Resending it</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    let resendBtn = document.querySelector('#resend');

    resendBtn.onclick = ()=>{

        window.util.$post('/resend/email/validation').then(reply=>{

            if(!reply.status){
                alert(reply.message);
                return false;
            }

            alert('Email validation sent!');

        }).catch(err=>{
            alert('Something went wrong');
        });
    }
</script>
@endsection

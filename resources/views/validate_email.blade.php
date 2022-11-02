@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3 mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Hello There!</h3>
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
                    <div class="row">
                        <div class="col form-group text-center">
                            <label>Did not receive any email?</label>
                            
                            <button id="resend" class="btn btn-primary">Try Resending it</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')

<div class="container">
   
    <div class="row justify-content-center mb-5 mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('Profile') }}</h3>
                </div>

                <div class="card-body">

                      <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label>Birthday</label>
                                <input type="text" class="form-control" readonly="true" value="{{$birthday}}"/>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label>Firstname</label>
                                <input type="text" class="form-control" readonly="true" value="{{$firstname}}"/>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label>Lastname</label>
                                <input type="text" class="form-control" readonly="true" value="{{$lastname}}"/>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control @if(!$email_confirmed) is-invalid @endif" readonly="true" value="{{$email}}"/>
                                
                                @if(!$email_confirmed)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Please validate your email to contiue using all our services and features</strong>
                                        <a href="/email">Click Here</a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
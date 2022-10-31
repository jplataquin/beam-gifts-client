@extends('layouts.app')

@section('content')

<div class="container">
   
    <div class="row justify-content-center">
        <div class="col-8 mb-3">
            <h1>Profile</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8 mb-3">
            <div class="form-group">
                <label>Birthday</label>
                <input type="text" class="form-control" readonly="true" value="{{$birthday}}"/>
            </div>
        </div>

        <div class="col-8 mb-3">
            <div class="form-group">
                <label>Firstname</label>
                <input type="text" class="form-control" readonly="true" value="{{$firstname}}"/>
            </div>
        </div>
        <div class="col-8 mb-3">
            <div class="form-group">
                <label>Lastname</label>
                <input type="text" class="form-control" readonly="true" value="{{$lastname}}"/>
            </div>
        </div>
        <div class="col-8 mb-3">
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" readonly="true" value="{{$email}}"/>
            </div>
        </div>
    </div>
</div>
@endsection
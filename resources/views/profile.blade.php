@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Profile</h1>

    <div class="row">
        <div class="col-12">
            <div class="form-group mb-3">
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
                <input type="text" class="form-control" readonly="true" value="{{$email}}"/>
            </div>
        </div>
    </div>
</div>
@endsection
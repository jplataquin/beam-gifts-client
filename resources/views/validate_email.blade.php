@extends('layouts.app')

@section('content')

<div class="container pb-5">
    <div class="text-center">
        <h3>To contiue with all our features and services please validate ownership of your email</h3>
        <h5>We sent validation link to your E-mail</h5>
    </div>

    <div class="row">
        <div class="col form-group">
            <label>Email</label>
            <input type="email" class="form-control" value="{{$email}}"/>
        </div>
    </div>
    <div class="row">
        <div class="col form-group text-end">
            <label>Did not receive any email?</label>
            <br>
            <button id="resend" class="btn btn-primary">Resend</button>
        </div>
    </div>
</div>
@endsection

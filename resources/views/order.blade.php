@extends('layouts.app')

@section('content')
  
    <div class="container">
        <div class="row">
            <div class="col">

                <h3>Order Ref: {{$order->uid}}</h3>
                <h3>Status: {{$status}}</h3>
            </div>
        </div>
    </div>
@endsection
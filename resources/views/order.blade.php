@extends('layouts.app')

@section('content')
  
    <div class="container">
        <div class="row">
            <div class="col-12">

                <h5>Order Ref: {{$order->uid}}</h5>
               
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h5>Status: {{$status}}</h5>
            </div>
            <div class="col-6">
                <h5>Total: PHP {{number_format($order->amount,2)}}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h5>Payment Method: {{$payment_method}}</h5>
            </div>
            <div class="col-6">
                <h5>Date Created: {{$date_created}}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h5>Date Paid: {{$date_paid}}</h5>
            </div>
            <div class="col-6">
               
            </div>
        </div>
    </div>

    <h1>Items</h1>
    <div>
        @foreach($order->items as $item)
            <div>
                {{$item->name}}
            </div>
        @endforeach
    </div>
@endsection
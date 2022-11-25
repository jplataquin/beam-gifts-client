@extends('layouts.app')

@section('content')
  
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="card mt-5 mb-5">
                    <div class="card-header text-center">
                        <strong>Order Ref:</strong> {{$order->uid}}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Status: {{$status}}</h5>
                        <p>Total: PHP {{number_format($order->amount,2)}}</p>
                        <p>Payment Method: {{$payment_method}}</p>
                        <p>Date Created: {{$date_created}}</p>
                        <p>Date Paid: {{$date_paid}}</p>
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach($items as $item)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-lg-2 text-center">
                                    <img src="{{config('app')['api_base_url']}}storage/photos/item/200px/{{ json_decode($item->model->photo,true)['200px'] }}" alt=""  width="200px"/>
                                </div>
                                <div class="col-lg-5">
                                    <h5>{{$item->item_name}}</h5>
                                    
                                    <strong>Used</strong>
                                    <br>
                                    {{$item->consumed}} / {{$item->quantity}}
                                    <br>
                                    <strong>Value</strong>
                                    <br>
                                    {{$item->price}}
                                    
                                </div>
                                <div class="col-lg-5">
                                    
                                </div>
                            </div>
                    
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>


    </div>


@endsection
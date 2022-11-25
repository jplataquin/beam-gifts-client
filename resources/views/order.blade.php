@extends('layouts.app')

@section('content')
  
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="card mt-5 mb-5">
                    <div class="card-header text-center">
                        <strong>Order Ref:</strong> {{ str_pad($order->id,6,0,STR_PAD_LEFT)}}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Status: <span style="color:green">{{$status}}</span> </h5>
                        <p>
                            <strong>Total:</strong> PHP {{number_format($order->amount,2)}}</p>
                        <p>
                            <strong>Payment Method:</strong> {{$payment_method}}</p>
                        <p>
                            <strong>Date Created:</strong> {{$date_created}}</p>
                        <p>
                            <strong>Date Paid:</strong> {{$date_paid}}</p>
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach($items as $item)
                        <li class="list-group-item mb-2">
                            <div class="row">
                                <div class="col-lg-12 bg-darkmagenta pl-2 pt-2">
                                    <h5 class="fontcolor-white" >{{$item->item_name}}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 text-center mb-2">
                                    <img src="{{config('app')['api_base_url']}}storage/photos/item/200px/{{ json_decode($item->model->photo,true)['200px'] }}" alt=""  width="100%"/>
                                </div>
                                <div class="col-lg-5 col">
                                    
                                    
                                    <strong>Used</strong>
                                    <br>
                                    {{$item->consumed}} / {{$item->quantity}}
                                    <br>
                                    <strong>Value</strong>
                                    <br>
                                    {{$item->price}}
                                    
                                </div>
                                <div class="col-lg-5 col pt-2 text-center">
                                    <div class="d-grid gap-2 mx-auto">
                                        <button class="btn btn-warning mb-2">Copy Link</button>
                                        <a class="btn btn-primary mb-2" href="/gift/$order->uid/{{$item->uid}}" target="__blank">Open Link</a>
                                    </div>
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
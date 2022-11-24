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
                                <div class="col">
                                {{$item->model->photo}}
                                </div>
                                <div class="col">
                                    {{$item->item_name}}
                                </div>
                                <div class="col">
                                    {{$item->consumed}} / {{$item->quantity}}
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
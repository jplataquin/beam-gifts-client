@extends('layouts.app')

@section('content')
  
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header text-center">
                        Order Ref: {{$order->uid}}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Status: {{$status}}</h5>
                        <p>Total: PHP {{number_format($order->amount,2)}}</p>
                        <p>Payment Method: {{$payment_method}}</p>
                        <p>Date Created: {{$date_created}}</p>
                        <p>Date Paid: {{$date_paid}}</p>
                    </div>
                </div>

            </div>
        </div>

        <h1>Items</h1>
        <div>
            @foreach($items as $item)
                <div>
                    {{$item->model->photo}}
                    <div>
                        {{$item->item_name}}
                    </div>
                    {{$item->consumed}} / {{$item->quantity}}
                </div>
            @endforeach
        </div>
    </div>


@endsection
@extends('layouts.app')

@section('content')

    <div class="container">

        @foreach($items as $item)
            <div class="row mb-3">
                <div class="col-2">
                    <img class="img" src="{{config('app')['api_base_url']}}storage/photos/item/150px/{{$item->attributes['image']}}"/>
                </div>
                <div class="col-7">
                    <h3>{{$item->name}}</h3>
                    <h5>{{$item->brand}}</h5>
                    Qty: {{$item->quantity}}
                </div>
                <div class="col-3">
                    <h3>PHP {{number_format($item->quantity * $item->price,2)}}</h3>
                </div>
            </div>
        @endforeach

    </div>

@endsection
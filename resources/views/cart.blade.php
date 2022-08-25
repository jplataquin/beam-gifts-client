@extends('layouts.app')

@section('content')

    <div class="container">

        @foreach($items as $item)
            <div class="row mb-3">
                <div class="col-2">
                    <img class="img" src="{{config('app')['api_base_url']}}storage/photos/item/150px/{{$item->attributes['image']}}"/>
                </div>
                <div class="col-10">
                    <h3>{{$item->name}}</h3>
                    Qty: {{$item->quantity}}
                </div>
            </div>
        @endforeach

    </div>

@endsection
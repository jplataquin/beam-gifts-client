@extends('layouts.qr')

@section('content')

<div>
    <div class="text-center">
        <img class="img" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$photo['400px']}}"/>
        <h2>{{$item->item_name}}</h2>
    </div>

</div>

@endsection
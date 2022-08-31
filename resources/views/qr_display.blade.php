@extends('layouts.qr')

@section('content')

<div>
    <div>
        <img class="img" src="{{config('app')['api_base_url']}}storage/photos/item/400px/{{$photo['400px']}}"/>
    </div>
</div>

@endsection
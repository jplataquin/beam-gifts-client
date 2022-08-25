@extends('layouts.app')

@section('content')

    <div class="container">

        @foreach($items as $item)
            <div>
                <h3>{{$item->name}}</h3>
            </div>
        @endforeach

    </div>

@endsection
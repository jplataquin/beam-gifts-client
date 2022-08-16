@extends('layouts.app')

@section('content')

<div class="container">
    <h1>{{ $brand->name }}</h1>
    <div class="row mb-3">
        <div class="col">
            <img class="img" src="{{config('app')['api_base_url']}}storage/photos/brand/400px/{{$brand->photo['400px']}}"/>
        </div>
        <div class="col">
            @foreach($brand->branches as $branch)
                <div class="border border-primary p-1 mb-2">
                    <h5>{{$branch['name']}}</h5>
                    <label>{{$branch['address']}}</label>
                    <h6>{{$branch['phone']}}</h6>
                </div>
            @endforeach
          
        </div>
    </div>
    <div class="row">
        <div class="col">
        <p>{{ $brand->description }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @foreach($items as $item)
                <div class="card" style="width: 200px;">
                    <img src="{{config('app')['api_base_url'].'storage/photos/item/200px/'.$item->photo['200px']}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5>
                        <a href="/item/{{str_replace(' ','-',$brand->name)}}/{{str_replace(' ','-',$item->name)}}" class="btn btn-primary">Buy Gift</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

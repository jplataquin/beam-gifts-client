@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <img class="product-img" src="{{config('app')['api_base_url']}}storage/photos/brand/400px/{{$brand->photo['400px']}}"  width="100%"/>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <h5 class="product-title">{{ $brand->name }}</h5>
            <p class="product-shortDESC brandDescription">{{ $brand->description }}
                asdasdasdasdsadasdajsdijasodjaoidjoiasjdad
                iaijdsoiasjdoijasodijasd
                oaiojsdoajoidasjdjas
                oiajodsijaidojasiodjasoidjasoijdaoisdjoaijdasd
                oijiadiojaidjaidjisoadjiasojdsiajdajsdaojsdoajdiasojdioasjdas
                aoijsdoiajdoiasjdioajsidojaiodjiasodjiajdasoidjaiodjioadjiasdj
                oiaijidojasiojaiodjiajdiajdiasjdiasjidjsaidjioadjosijdioasjaoijsd
                oiajsdoiajsoidjasiodjasiodjaoidjaoidjasiojdasiodjoiajdaisdjadioasjiodjasd
                oiajsdoiajdoiajidjasiodjasiodjaoisdjisajdioasdjasiodjasdjads
                
                oijiadiojaidjaidjisoadjiasojdsiajdajsdaojsdoajdiasojdioasjdas
                aoijsdoiajdoiasjdioajsidojaiodjiasodjiajdasoidjaiodjioadjiasdj
                oiaijidojasiojaiodjiajdiajdiasjdiasjidjsaidjioadjosijdioasjaoijsd
                oiajsdoiajsoidjasiodjasiodjaoidjaoidjasiojdasiodjoiajdaisdjadioasjiodjasd
                oiajsdoiajdoiajidjasiodjasiodjaoisdjisajdioasdjasiodjasdjads
                oijiadiojaidjaidjisoadjiasojdsiajdajsdaojsdoajdiasojdioasjdas
                aoijsdoiajdoiasjdioajsidojaiodjiasodjiajdasoidjaiodjioadjiasdj
                oiaijidojasiojaiodjiajdiajdiasjdiasjidjsaidjioadjosijdioasjaoijsd
                oiajsdoiajsoidjasiodjasiodjaoidjaoidjasiojdasiodjoiajdaisdjadioasjiodjasd
                oiajsdoiajdoiajidjasiodjasiodjaoisdjisajdioasdjasiodjasdjads
                oijiadiojaidjaidjisoadjiasojdsiajdajsdaojsdoajdiasojdioasjdas
                aoijsdoiajdoiasjdioajsidojaiodjiasodjiajdasoidjaiodjioadjiasdj
                oiaijidojasiojaiodjiajdiajdiasjdiasjidjsaidjioadjosijdioasjaoijsd
                oiajsdoiajsoidjasiodjasiodjaoidjaoidjasiojdasiodjoiajdaisdjadioasjiodjasd
                oiajsdoiajdoiajidjasiodjasiodjaoisdjisajdioasdjasiodjasdjads
            </p>
            
            <div class="branchList">
                @foreach($brand->branches as $branch)
                    <div class="border border-primary p-1 mb-2">
                        <h5>{{$branch['name']}}</h5>
                        <label>{{$branch['address']}}</label>
                        <h6>{{$branch['phone']}}</h6>
                    </div>
                @endforeach
                @foreach($brand->branches as $branch)
                    <div class="border border-primary p-1 mb-2">
                        <h5>{{$branch['name']}}</h5>
                        <label>{{$branch['address']}}</label>
                        <h6>{{$branch['phone']}}</h6>
                    </div>
                @endforeach
                @foreach($brand->branches as $branch)
                    <div class="border border-primary p-1 mb-2">
                        <h5>{{$branch['name']}}</h5>
                        <label>{{$branch['address']}}</label>
                        <h6>{{$branch['phone']}}</h6>
                    </div>
                @endforeach
            </div>
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

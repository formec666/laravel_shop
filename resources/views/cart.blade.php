@extends('layout')

@php
  $total=0;  
@endphp

@section('title')
    Cart
@endsection

@section('content')
<div class="" >
    <a href="/" class="flex text-lg hover:text-laravel items-center ">
        <i class="fa-arrow-left fas m-6"> </i>do obchodu
    </a>
@if($data==null)
    Váš košík je prázdný
@else
@foreach ((array) $data as $pair)
    
    
    <div class="bg-grey-50 m-6 tw-border-solid border-slate-400 flex flex-row items-center justify-between ">
    @foreach((array)$pair as $amount=>$details)
        
        @php
          foreach ((array)$details as $key => $value) {
            $product[$key]=$value;
            
          }  
        @endphp
        
    @endforeach
    @php
        $total=$total+$product['price']*$amount;   
    @endphp
    
        
    <img src="{{$product['image'] ? asset('storage/'.$product['image']): asset('\images\2.jpg')}}" class="w-10">
    <div class="text-center">
        <div class="font-semibold text-lg">{{$product['name']}}</div>
        <div class="text-slate-400">({{$product['id']}})</div>
    </div>
    <input type="number" id="amount{{$product['id']}}" min=0 onchange="display({{$product['id']}}, {{$product['price']}}, this.value)" value="{{$amount}}" class="w-24 bg-white border-solid border-2 border-grey-500 rounded-md text-center">
    <div>
        <span class="text-lg" id='price{{$product['id']}}'>
            {{$product['price']*$amount}} Kč
        </span>
        <div class="text-slate-400">{{$product['price']}} / ks</div>
    </div>
    <i class='fa-solid fa-trash fill-black' onclick="display({{$product['id']}}, {{$product['price']}}, 0)"></i>
    </div>
    <hr>


@endforeach
    

     <script>
       
        async function display( id,  price,  amount){
            
            let response = await fetch('/cart/addSum?id='+id+'&amount='+amount);

            if (response.ok) { // if HTTP-status is 200-299
             // get the response body (the method explained below)
             let result = await response.json();
             document.getElementById("total").innerHTML=result.sum;
             document.getElementById("price"+id).innerHTML=price*amount+' Kč';
             document.getElementById("amount"+id).value=amount;
            } else {
                  alert("HTTP-Error: " + response.status);
            }}

        
    </script> 
</div>
<div class="text-center">Celkem <span id="total"> {{$total}} </span> Kč</div>
<a href="/order" class="flex text-lg hover:text-laravel justify-center">Dokončit objednávku</a>
@endif
@endsection
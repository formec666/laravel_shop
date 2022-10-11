@extends('layout')

@php
 $total=0;   
@endphp

@section('title')
 Order   
@endsection

@section('content')
<div class="flex flex-row justify-evenly">
    <div class="bg-laravel p-6 border-2 border-amber-400">
        <i class="fa-solid fa-shopping-cart"></i>
        @foreach ((array)$data as $pair)
            @foreach((array)$pair as $amount=>$details)
                @php
                    foreach ((array)$details as $key => $value) 
                    {
                        $product[$key]=$value;              
                    }  
                @endphp
            @endforeach
            @php
                $total=$total+$product['price']*$amount;   
            @endphp
            <br>{{$amount}} x {{$product['name']}}
        @endforeach
        <br>
        {{$total}} Kč
    </div>
    <div>
        <form class="flex-1 flex flex-col" action="/order" method="POST">
            @csrf
            <input type="hidden" name="total" value="{{$total}}">
            <input type="hidden" name="cart" value="{{json_encode($cart)}}">
            <label for="name">Jméno</label>
            @error('name')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
            <input type="text" name ="name" @auth value={{auth()->user()->name}}@endauth class="w-full bg-white border-solid border-2 border-grey-500 rounded-md text-center p-2">
            <label for="email">Email</label>
            @error('email')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
            <input type="email" name="email" @auth value={{auth()->user()->email}}@endauth class="w-full bg-white border-solid border-2 border-grey-500 rounded-md text-center p-2">
            <label for="address">Adresa</label>
            <input type="text" name="address" id="address" class="w-full bg-white border-solid border-2 border-grey-500 rounded-md text-center p-2">
            @error('address')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
            <label for="invoiceName">Jméno na fakturu</label>
            @error('invoiceName')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
            <input type="text" name="invoiceName" class="w-full bg-white border-solid border-2 border-grey-500 rounded-md text-center p-2">
            <label for="invoiceAddress">Fakturační adresa</label>
            @error('invoiceAddress')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
            <input type="text" name="invoiceAddress" class="w-full bg-white border-solid border-2 border-grey-500 rounded-md text-center p-2">
            <label>
                <input type="radio"  name="payment_method" value="card">
                Online
            </label>
            <label>
                <input type="radio"  name="payment_method" value="Dobírka">
                Při převzetí
            </label>
            @error('payment_method')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
            @enderror
            <input type="submit" value="Vytvořit objednávku">
        </form>
    </div>
</div>
   
@endsection
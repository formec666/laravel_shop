@extends('layout')

@section('content')
        <h1 style="font-size: 1.5rem; line-height: 2rem; text-align: center;">
            Vaše objednávka byla vytvořena
        </h1>
        <h2 style="padding:6px; font-size: 1.25rem;
        line-height: 1.75rem; ">
            
        </h2>
        <h2 style="font-size: 1.25rem; text-align: center;
        line-height: 1.75rem; ">
            Vytvořili jsme objednávku č. {{$order->id}} kterou již brzy odešleme zákazníkovi {{$order->name}} na adresu {{$order->address}}
        </h2>
        <ul style="padding: 6px; text-align: center; ">
            @foreach (json_decode($order->cart) as $item)
                <li>{{$item->amount}}x {{$item->product->name}} ({{$item->product->price*$item->amount}}Kč)</li>
            @endforeach
        </ul>
        <h2 style="font-size: 1.25rem; text-align: center;
        line-height: 1.75rem; ">
           Celková cena činní {{$order->total}} Kč
        </h2>
        @if ($url)
            <a href={{$url}} class="h-10 text-black rounded-lg bg-laravel hover:bg-gold hover:shadow-lg hover:cursor-pointer p-6" > Zaplatit obědnávku</a>
        @else
            Způsob platby: {{$payment}}
        @endif
        
    @endsection
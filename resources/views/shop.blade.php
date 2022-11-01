@extends('layout')

@section('title')
E-shop
@endsection

@section('content')

    <!-- Search -->
    <form action="">
        <div class="relative border-2 border-gray-100 m-4 rounded-lg">
            <div class="absolute top-4 left-3">
                <i
                    class="fa fa-search text-gray-400 z-20 hover:text-gray-500"
                ></i>
            </div>
            <input
                type="text"
                name="search"
                class="h-14 w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none"
                placeholder="Vyhledat zboží"
            />
            <div class="absolute top-2 right-2">
                <button
                    type="submit"
                    class="h-10 w-20 text-black rounded-lg bg-laravel hover:bg-gold"
                >
                    Hledat
                </button>
            </div>
        </div>
    </form>
    <form action=''>

    </form>
        
    <div
        class="md:grid md:grid-cols-2 lg:grid-cols-3 gap-4 space-y-4 md:space-y-0 mx-4"
    >
    

    @if(count($products)==0)
        <div>
            <h1>Zboží jsme nenašli</h1>
        </div>
    @endif
    
    @foreach ($products as $product)
    @php
     $tags = explode(',', $product['tags']);   
    @endphp
    
    <div href="product{{$product['id']}}" class=" bg-gray-50 border border-gray-200 rounded p-6">
        <a href="/products/{{$product['id']}}">
        <div class="grid place-items-center text-center" >
            <img
                class="w-48 md:center"
                src="{{$product->image ? asset('storage/'.$product->image): asset('\images\2.jpg')}}"
                alt=""
            />
            <div>
                <h3 class="text-2xl ">
                   {{$product['name']}}
                </h3>
                <div class="text-xl font-bold mb-4">{{$product['price']}} Kč</div>
                <ul class="flex justify-center">
                    @foreach($tags as $tag)
                    <li
                        class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
                    >
                        <a href="/?tags={{$tag}}">{{$tag}}</a>
                    </li>
                    @endforeach
                </ul>
                <div class="text-lg mt-4">
                    <i class="fa-solid fa-location-dot"></i> {{$product->available}}
                </div>
            </div>
        </div>
    </a>
    </div>
    @endforeach
    
    </div><div class="mt-6 p-6">
    {{$products->links()}}
        </div>
    <button class="fixed right-0 bottom-1/3 " ><a href="/cart/show"><i class="fa fa-shopping-cart fa-xl md:fa-4x bg-laravel p-6 rounded-l-full "></i></a></button>
@endsection

@php
    use App\Http\Controllers\StorageController;
@endphp

@extends('layout')

@section('title')
{{$product['name']}}
@endsection

@section('content')
<a href="/" class="inline-block text-black ml-4 mb-4"
                ><i class="fa-solid fa-arrow-left"></i> Zpět
            </a>
            <div class="mx-4">
                <div class="bg-gray-50 border border-gray-200 p-10 rounded">
                    <div
                        class="flex flex-col items-center justify-center text-center"
                    >
                        <img
                            class="w-48 mr-6 mb-6"
                            src="{{$product->image ? asset('storage/'.$product->image): asset('\images\2.jpg')}}"
                            alt=""
                        />

                        <h3 class="text-2xl mb-2">{{$product->name}}</h3>
                        <div class="text-xl font-bold mb-4">{{$product['price']}} Kč</div>
                        <ul class="flex">
                            @php
                                $tags = 'hello';
                                $tags=explode(',', $product['tags'])
                            @endphp
                            @if($tags != 'hello')
                              @foreach($tags as $tag)
                                <li
                                class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
                                >   
                                  <a href="/?tags={{$tag}}">{{$tag}}</a>
                                </li>
                            @endforeach  
                            @endif
                            
                        </ul>
                        <div class="text-lg my-4">
                            <i class="fa-solid fa-location-dot"></i> {{StorageController::getTotal($product->item)}}
                        </div>
                        <form class="flex flex-col justify-center " action="/cart/add">
                            
                            <input type="number" name="amount" id="amount" class="m-6 flex flex-col text-center p-1" value="1" min="1" >
                            <button
                                    type="submit"  
                                    class="block bg-laravel text-white  py-2 rounded-xl hover:opacity-80 p-6"
                                    ><i class="fa-solid fa-shopping-cart"></i>
                                    Do košíku</button>
                                    <input type="text" readonly="readonly" name="id" id="id" class="text-center bg-transparent cursor-default" value="{{$product->id}}">
                            </form>
                        <div class="border border-gray-200 w-full mb-6"></div>
                        <div>
                            <h3 class="text-3xl font-bold mb-4">
                                Popis produktu
                            </h3>
                            <div class="text-lg space-y-6">
                                {{$product->description}}

                                

                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
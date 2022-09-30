@extends('layout')

@section('title')
    Edit {{$listing['name']}}
@endsection

@section('content')
<form class="p-6" method="POST" action="/products/{{$listing['id']}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    

    <div class="mb-6">
      <label for="name" class="inline-block text-lg mb-2">
        Název produktu
      </label>
      <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
        value="{{$listing['name']}}" />

      @error('name')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    
    <div class="mb-6">
        <label for="price" class="inline-block text-lg mb-2">
          Cena v Kč
        </label>
        <input type="number" class="border border-gray-200 rounded p-2 w-full" name="price"
          value="{{$listing['price']}}" />
  
        @error('price')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

    <div class="mb-6">
      <label for="tags" class="inline-block text-lg mb-2">
        Tags (oddělené čárkou)
      </label>
      <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
        placeholder="Example: Laravel, Backend, Postgres, etc" value="{{$listing->tags}}" />

      @error('tags')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="logo" class="inline-block text-lg mb-2">
        Obrázek
      </label>
      <input type="file" class="border border-gray-200 rounded p-2 w-full" name="logo" />

      <img class="w-48 mr-6 mb-6"
        src="{{$listing->image ? asset('storage/'.$listing->image): asset('\images\2.jpg')}}" alt="" />

      @error('logo')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="description" class="inline-block text-lg mb-2">
        Popis produktu
      </label>
      <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
        placeholder="Include tasks, requirements, salary, etc">{{$listing->description}}</textarea>

      @error('description')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="description" class="inline-block text-lg mb-2">
        Připojit k položce ze skladu
      </label>
      <select name="item_id" id="">
        @foreach($items as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>
        @endforeach
      </select>

      @error('item_id')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
        Aktualizovat produkt
      </button>

      <a href="/admin/products" class="text-black ml-4"> Zpět </a>
    </div>
  </form>   
@endsection
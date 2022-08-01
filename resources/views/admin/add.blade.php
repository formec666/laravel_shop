@extends('layout')

@section('title')
    Add
@endsection

@section('content')
<form class="p-6" method="POST" action="/products" enctype="multipart/form-data">
    @csrf
       

    <div class="mb-6">
      <label for="name" class="inline-block text-lg mb-2">
        Název produktu
      </label>
      <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
        value="" />

      @error('name')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    
    <div class="mb-6">
        <label for="price" class="inline-block text-lg mb-2">
          Cena v Kč
        </label>
        <input type="number" class="border border-gray-200 rounded p-2 w-full" name="price"
          value="" />
  
        @error('price')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

    <div class="mb-6">
      <label for="tags" class="inline-block text-lg mb-2">
        Tags (oddělené čárkou)
      </label>
      <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
        placeholder="Example: Laravel, Backend, Postgres, etc" value="" />

      @error('tags')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="image" class="inline-block text-lg mb-2">
        Obrázek
      </label>
      <input type="file" class="border border-gray-200 rounded p-2 w-full" name="image" />

      

      @error('logo')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="description" class="inline-block text-lg mb-2">
        Popis produktu
      </label>
      <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
        placeholder="Include tasks, requirements, salary, etc"></textarea>

      @error('description')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
        Uložit
      </button>

      <a href="/admin/products" class="text-black ml-4"> Zpět </a>
    </div>
  </form>

@endsection
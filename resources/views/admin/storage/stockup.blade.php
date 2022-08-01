@extends('layout')

@section('title')
    Naskladnit {{$item['name']}}
@endsection

@section('content')
<h1  class=" text-2xl mb-2 text-center">Naskladnit</h1>
<h1  class=" text-3xl mb-2 font-bold text-center" >{{$item['name']}}</h1>
<h1  class=" text-2xl mb-2 text-center">{{$item['distributor']}}</h1>
<form class="p-6" method="POST" action="/admin/storage/stockup/{{$item['id']}}" enctype="multipart/form-data">
    @csrf
    
    
    
    <div class="mb-6">
      <label for="price" class="inline-block text-lg mb-2">
        Cena (v Kč)
      </label>
      <input type="number" class="border border-gray-200 rounded p-2 w-full" name="price"
         value="{{old('price')}}"/>

      @error('price')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
        <label for="description" class="inline-block text-lg mb-2">
          Popis výdaje
        </label>
        <textarea type="text" class="border border-gray-200 rounded p-2 w-full" name="description"
           >{{old('description')}}</textarea>
  
        @error('description')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="document" class="inline-block text-lg mb-2">
          Dokumentace
        </label>
        <input type="file" class="border border-gray-200 rounded p-2 w-full" name="document"
           />
  
        @error('document')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    </div>
    <div class="mb-6">
        <label for="storage" class="inline-block text-lg mb-2">
          Úložiště
        </label>
        <select type="text" class="border border-gray-200 rounded p-2 w-full" name="storage"
           value='{{old('description')}}'>
            @foreach($storages as $storage)
            <option value='{{$storage['id']}}'>{{$storage['name']}}</option>
            @endforeach
        </select>
  
        @error('storage')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    </div>
    <div class="mb-6">
        <label for="amount" class="inline-block text-lg mb-2">
          Množství ({{$item['unit']}})
        </label>
        <input type="number" class="border border-gray-200 rounded p-2 w-full" name="amount"
           value='{{old('description')}}'/>
            
  
        @error('amount')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    </div>
    <div class="mb-6">
        <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
            Naskladnit položku
          </button>
          <a href="/admin/storage" class="text-black ml-4"> Zpět </a>
    </div>
</form>
       
@endsection
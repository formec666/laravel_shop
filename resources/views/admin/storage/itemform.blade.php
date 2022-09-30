@extends('layout')

@section('title')
    Přidat položku do skladu
@endsection

@section('content')
<form class="p-6" method="POST" action="/admin/storage/add" enctype="multipart/form-data">
    @csrf
    
    <h2 class="text-2xl font-bold uppercase mb-1">
        Přidat Položku do skladu
    </h2>

    <div class="mb-6">
      <label for="name" class="inline-block text-lg mb-2">
        Název položky
      </label>
      <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
        value="{{old('name')}}" />

      @error('name')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    
    <div class="mb-6">
        <label for="unit" class="inline-block text-lg mb-2">
          Jednotky
        </label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="unit"
        value="{{old('unit')}}"/>
  
        @error('unit')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

    <div class="mb-6">
      <label for="distributor" class="inline-block text-lg mb-2">
        Distributor
      </label>
      <input type="text" class="border border-gray-200 rounded p-2 w-full" name="distributor"
        placeholder="Example: OBI, Amazon.com " value="{{old('distributor')}}"/>

      @error('distributor')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="through" class="inline-block text-lg mb-2">
        Automatická výroba- položku není třeba vyrábět, při výrobě která má v receptu tuto položku se automaticky odečtou všechny položky ze kterých se tato vyrábí
      </label>
      <input type="checkbox" class="border border-gray-200 rounded p-2 w-full" name="through"
        placeholder="Example: OBI, Amazon.com " value="{{old('distributor')}}"/>

      @error('through')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="description" class="inline-block text-lg mb-2">
        Popis položky
      </label>
      <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
        placeholder="Například na co se používá">{{old('description')}}</textarea>

      @error('description')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
        Vytvořit položku
      </button>

      <a href="/admin/storage" class="text-black ml-4"> Zpět </a>
    </div>
  </form>   
@endsection
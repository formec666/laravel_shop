@extends('layout')

@section('title')
 {{$item->name}}   
@endsection

@section('content')

<form class="m-6" action="/admin/storage/writeoff/{{$item->id}}" method="POST">
    <h2 class="text-2xl font-bold uppercase mb-1">
        Odepsat položku
    </h2>
    @csrf
<div class="mb-6">

    
    <label for="description" class="inline-block text-lg mb-2">
      Popis odpisu
    </label>
    <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
      placeholder="Například co se se zbožím stalo">{{old('description')}}</textarea>

    @error('description')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror
  </div>
  <div class="mb-6">
    <label for="amount" class="inline-block text-lg mb-2" >
      Odepisované množství ({{$item->unit}})
    </label>
    <input type="number" name="amount" id="" class="border border-gray-200 rounded p-2 w-full" min="1" max="{{$item->total}}">

    @error('description')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror
  </div>
  <div class="mb-6">
    <label for="storage_space_id" class="inline-block text-lg mb-2" >
      Ze skladovacího prostoru 
    </label>
    <select name="storage_space_id" id="" class="border border-gray-200 rounded p-2 w-full" min="1" >
        @foreach($item->isStored as $storage)
        <option value="{{$storage->in}}">{{$storage->storageSpace['name']}}</option>
        @endforeach
    </select>

    @error('description')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror
  </div>
  <div class="mb-6">
    <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
      Odepsat položku
    </button>

    <a href="/admin/storage" class="text-black ml-4"> Zpět </a>
  </div>

</form>
@endsection
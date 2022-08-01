@extends('layout')

@section('title')
    Vytvořit Prostor
@endsection

@section('content')
<form class="p-6" method="POST" @if(isset($space))action='/admin/storage/spaces/edit/{{$space->id}}'@else action="/admin/storage/spaces" @endif enctype="multipart/form-data">
    @csrf
    @if (isSet($space))
     @method('put')
        @endif

    <div class="mb-6">
      <label for="name" class="inline-block text-lg mb-2">
        Název úložiště
      </label>
      <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
      @if (isSet($space))
          value='{{$space->name}}'
      @endif
         />

      @error('name')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    
    

    <div class="mb-6">
      <label for="description" class="inline-block text-lg mb-2">
        Popis úložiště
      </label>
      <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
        placeholder="Kde se úložiště nachází, jak postupovat při jeho použití a podobné"
        >@if (isSet($space)){{$space->description}}
        @endif
    </textarea>

      @error('description')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
        Aktualizovat produkt
      </button>

      <a href="/admin/storage/spaces" class="text-black ml-4"> Zpět </a>
    </div>
  </form>   
@endsection
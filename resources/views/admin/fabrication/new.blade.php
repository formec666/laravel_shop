@extends('layout')

@section('title')
    Nové Pravidlo

@endsection

@section('content')
<form class="p-2 landscape:flex-row landscape:justify-between" action="/admin/fabrication/" method="POST">
    @csrf
    <div class="m-2">
        <label for="input" >Ingredience</label>
        <select name="input" class="border border-gray-200 rounded p-2 w-full " >
            @foreach($items as $item)
                <option value={{$item['id']}}
                >{{$item['name']}}</option>
            @endforeach
        </select>
        @error('input')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="m-2">
        <label for="from" >Výchozí úložiště</label>
        <select name="from" class="border border-gray-200 rounded p-2 w-full " >
            @foreach($storageSpaces as $item)
                <option value={{$item['id']}}
                >{{$item['name']}}</option>
            @endforeach
        </select>
        @error('from')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="m-2">
        <label for="amount" >Množství</label>
        <div class="border border-gray-200 rounded flex flex-row justify-between"><input type="number" name="amount" class="w-full p-2 rounded-l" ></div>
        @error('amount')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>
    <div class="m-2 text-center">
        <i class="fa fa-arrow-down fa-6x"></i>
    </div>
    <div class="m-2">
        <label for="output" >Výstup</label>
        <select name="output" class="border border-gray-200 rounded p-2 w-full " >
            @foreach($items as $item)
                <option value={{$item['id']}}
                >{{$item['name']}}</option>
            @endforeach
        </select>
        @error('output')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>
    <div class="m-2">
        <input type="submit" value="Přidat" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
    </div>
</form>
@endsection
@extends('layout')

@section('title')
    Přesun {{$item->name}}
@endsection

@section('content')
    <form class="p-2" method="POST" action="/admin/fabrication/{{$item->id}}">
            @csrf
            
                
                <label for="name" class="text-lg m-2">
                    
                    <h3 class="text-2xl m-2">{{$item->name}} ({{$item->unit}})</h3>
                    <div class="m-2">{{$item->description}}</div>
                    <div class="text-xl text-center">Ze skladovacího prostoru:</div>
                </label>
                <select class="border border-gray-200 rounded p-2 w-full " name="takeFrom[{{$item->id}}]">
                    <option value="">Vyberte</option>
                    @foreach($item->storages as $storage)

                        <option value="{{$storage->id}}">{{$storage['name']}}</option>
                    @endforeach
                </select>
                @error('takeFrom.*')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
            
            
            <label for="name" class="text-lg m-2  text-center">
                
                <h3 class="text-2xl m-2">{{$item->name}} ({{$item->unit}})</h3>
                <div class="text-xl text-center">Do skladovacího prostoru</div>
                
            </label>
            <select class="border border-gray-200 rounded p-2 w-full" name="storeIn">
                <option value="">Vyberte</option> 
                @foreach($storageSpaces as $storageSpace)
                    <option value="{{$storage->id}}">{{$storageSpace->name}}</option>
                @endforeach
            </select>
            @error('storeIn')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
            <label class="text-lg m-2 text-center">
                <div class="text-xl text-center">Přesunuté Množství</div>
            </label>
            <input type="number" name="amount" class="border border-gray-200 rounded p-2 w-full"></input>
            @error('amount')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
            <div class="text-center m-2">
                <input type="submit" value="Přesunout" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"></input>
            </div>
            
    </form>
@endsection
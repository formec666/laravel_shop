@extends('layout')

@section('title')
    Úprava receptů
@endsection

@section("content")
@php
 //dd($recipes);   
@endphp
<table class="w-full table-auto rounded-sm">
    <tbody>
        @foreach($recipes as $recipe)



        <tr class="border-gray-300">
            <td
                class="px-4 py-8 border-t border-b border-gray-300 text-lg"
            >
                <a href="/admin/storage/items/{{$recipe['id']}}">
                    {{$recipe->name}}<span class="text-sm text-slate-400"> ({{$recipe->unit}})</span>
                </a>
            </td>
            <td
                class="px-4 py-8 border-t border-b border-gray-300 text-lg"
            >
                {{$recipe->pivot->amount}}
            </td>
            <td
                class="px-4 py-8 border-t border-b border-gray-300 text-lg"
            >
                <form method="post" action="/admin/fabrication/edit/{{$recipe->pivot->id}}">
                    @method('DELETE')
                    @csrf
                    
                    <button class="text-red-600">
                        <i
                            class="fa-solid fa-trash"
                        ></i>
                        Zahodit
                    </button>
                </form>
            </td>
        </tr>
@endforeach
    </tbody>
</table>
@endsection
@extends('layout')

@section('title')

    Výroba

@endsection

@section('content')
    <a href="/admin/fabrication/new" class="flex text-3xl justify-center text-green-400 font-bold my-6 uppercase">
        <i class="fas fa-plus-circle fa-4x"></i>
    </a>

    <h1
        class="text-3xl text-center font-bold my-6 uppercase"
    >
        Přidat recept
    </h1>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @foreach($items as $item)
    

    
            <tr class="border-gray-300">
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a href="/admin/fabrication/{{$item['id']}}">
                        {{$item['name']}}<span class="text-sm text-slate-400"> ({{$item['id']}})</span>
                    </a>
                </td>
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a
                        href="/admin/fabrication/edit/{{$item['id']}}"
                        class="text-blue-400 px-6 py-2 rounded-xl"
                        ><i
                            class="fa-solid fa-pen-to-square"
                        ></i>
                        Edit</a
                    >
                </td>
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <form method="get" action="/admin/fabrication/move/{{$item['id']}}">
                        
                        
                        <button class="text-red-600">
                            <i
                                class="fa-solid fa-arrows"
                            ></i>
                            Přesunout
                        </button>
                    </form>
                </td>
            </tr>
    @endforeach
        </tbody>
    </table>


@endsection
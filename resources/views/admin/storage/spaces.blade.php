@extends('layout')

@section('title')
    Skladovací Prostory
@endsection

@section('content')
<a href="/admin/storage" class="text-black ml-4"> Zpět </a>
<form action="">
    <div class="relative border-2 border-gray-100 m-4 rounded-lg">
        <div class="absolute top-4 left-3">
            <i
                class="fa fa-search text-gray-400 z-20 hover:text-gray-500"
            ></i>
        </div>
        <input
            type="text"
            name="search"
            class="h-14 w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none"
            placeholder="Vyhledat skladovací prostor"
        />
        <div class="absolute top-2 right-2">
            <button
                type="submit"
                class="h-10 w-20 text-white rounded-lg bg-laravel hover:bg-gold"
            >
                Search
            </button>
        </div>
    </div>
</form>
<header>
        <a href="/admin/storage/spaces/create" class="flex text-3xl justify-center text-green-400 font-bold my-6 uppercase">
            <i class="fas fa-plus-circle fa-4x"></i>
        </a>

        <h1
            class="text-3xl text-center font-bold my-6 uppercase"
        >
            Přidat skladovací prostory
        </h1>
    </header>
    <div>
        <table class="w-full table-auto rounded-sm">
            <tbody>
                @foreach($spaces as $space)
        
    
        
                <tr class="border-gray-300">
                    <td
                        class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                    >
                        <a href="admin/storage/spaces/{{$space['id']}}">
                            {{$space['name']}}<span class="text-sm text-slate-400"> ({{$space['id']}})</span>
                        </a>
                    </td>
                    <td
                        class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                    >
                        <a
                            href="/admin/storage/spaces/edit/{{$space['id']}}"
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
                        <form method="POST" action="/admin/storage/spaces/{{$space['id']}}">
                            @csrf
                            @method('delete')
                            <button class="text-red-600">
                                <i
                                    class="fa-solid fa-trash-can"
                                ></i>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
        @endforeach
            </tbody>
        </table>


    </div>
@endsection
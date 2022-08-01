@extends('layout')

@section('title')
Sklad
@endsection

@section('content')
<div>
    <div class="grid md:grid-cols-2  gap-4 space-y-4 md:space-y-0 mx-4">
    <a href="/admin/storage/spaces" class=" bg-slate-500 border border-gray-200 rounded p-6">
        
        <div class="grid place-items-center text-xl font-semibold uppercase" >
            <i class='fa fa-cog fa-6x fa-spin '></i>
            Zpravovat úložné prostory
            
        </div>
        
    </a>
    <a href="/admin/storage/add" class=" bg-green-500 border border-gray-200 rounded p-6">
        
        <div class="grid place-items-center text-xl font-semibold uppercase" >
            <i class='fa fa-plus fa-6x fa-spin '></i>
            Vytvořit položku skladu
            
        </div>
        
    </a>
    </div>
    <div>
        <table class="w-full table-auto rounded-sm">
            <tbody>
                @foreach($items as $item)
        
    
        
                <tr class="border-gray-300">
                    <td
                        class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                    >
                        <a href="/admin/storage/items/{{$item['id']}}">
                            {{$item['name']}}<span class="text-sm text-slate-400"> ({{$item['unit']}})</span>
                        </a>
                    </td>

                    <td>
                        {{$item['distributor']}}

                    </td>

                    <td>
                        <h2>{{$item['total']}}</h2>

                    </td>

                    <td
                        class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                    >
                        <a
                            href="/admin/storage/stockup/{{$item['id']}}"
                            class="text-blue-400 px-6 py-2 rounded-xl"
                            ><i
                                class="fa-solid fa-pen-to-square"
                            ></i>
                            Naskladnit</a
                        >
                    </td>
                    <td
                        class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                    >
                        <form method="POST" action="/admin/storage/spaces/{{$item['id']}}">
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
</div>

@endsection
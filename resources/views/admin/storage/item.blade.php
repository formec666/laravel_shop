@extends('layout')

@section('title')
 {{$item->name}}   
@endsection

@section('content')
<a href="/admin/storage" class="inline-block text-black ml-4 mb-4"
                ><i class="fa-solid fa-arrow-left"></i> Zpět
            </a>
            <div class="mx-4">
                <div class="bg-gray-50 border border-gray-200 p-10 rounded">
                    <div
                        class="flex flex-col items-center justify-center text-center"
                    >
                        

                        <h3 class="text-3xl font-bold mb-2">{{$item->name}}</h3>
                                                
                        
                        
                            
                                    
                        <div class="border border-gray-200 w-full mb-6">
                            <table class="border-collapse w-full table-auto">
                                <tr >
                                    <th class="border borer-solid border-grey-500">Množství</th>
                                    <th class="border borer-solid border-grey-500">Skladovací prostor</th>
                                    <th class="border borer-solid border-grey-500">Datum poslední úpravy</th>
                                </tr>
                            @foreach ($item->isStored as $one)
                            <tr>
                                <td class="border borer-solid border-grey-500">{{$one->amount}}</td>
                                <td class="border borer-solid border-grey-500">{{$one->storageSpace['name']}}</td>
                                <td class="border borer-solid border-grey-500">{{$one->updated_at}}</td>
                            </tr>
                            @endforeach
                            </table>
                        </div>
                        <div>
                            <h3 class="text-2xl  mb-4">
                                Popis 
                            </h3>
                            <div class="text-lg space-y-6">
                                {{$item->description}}

                                

                            
                            </div>
                        </div>
                        <div>
                            <button
                                    type="submit"  
                                    class="block bg-laravel text-white  py-2 rounded-xl hover:opacity-80 p-6"
                                    ><i class="fa-solid fa-shopping-cart"></i>
                                    Objednat</button>
                        </div>
                    </div>
                </div>
            </div>
@endsection
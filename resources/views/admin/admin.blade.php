@extends('layout')

@section('title')
 Admin   
@endsection

@section('content')

@php
    $sites=[[
        'name'=>'produkty',
        'uri'=>'products',
        'bg'=>'bg-red-500',
        'icon'=>'fas fa-barcode fa-6x'
    ], [
        'name'=>'objednávky',
        'uri'=>'orders',
        'bg'=>'bg-green-500',
        'icon'=>'fas fa-paper-plane fa-6x'
    ],[
        'name'=>'finance',
        'uri'=>'finance',
        'bg'=>'bg-yellow-500',
        'icon'=>'fa-solid fa-credit-card fa-6x'
], [
    'name'=>'zaměstnanci',
    'uri'=>'employees',
    'bg'=>'bg-blue-500',
    'icon'=>'fa fa-id-card fa-6x'
], [
    'name'=>'archiv',
    'uri'=>'archive',
    'bg'=>'bg-gray-400',
    'icon'=>'fa fa-archive fa-6x'
], [
    'name'=>'Sklad',
    'uri'=>'storage',
    'bg'=>'bg-amber-200',
    'icon'=>'fa fa-cubes fa-6x'
]];

//$sites=file_get_contents('http://127.0.0.1:8000/admin/getSites');
@endphp

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 space-y-4 md:space-y-0 mx-4">
    @foreach($sites as $site)
    <a href="/admin/{{$site['uri']}}" class=" {{$site['bg']}} border border-gray-200 rounded p-6">
        
        <div class="grid place-items-center text-xl font-semibold uppercase" >
            <i class='{{$site['icon']}} '></i>
            {{$site['name']}}
            
        </div>
    </a>
    @endforeach
</div>

@endsection
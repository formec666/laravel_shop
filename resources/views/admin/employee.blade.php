@extends('layout')

@section('title')
Register
@endsection

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
    'icon'=>'fa fa-user fa-6x'
]];
$isAllowed=json_decode($employee->isAllowed);
$i=0;
foreach ($isAllowed as $key => $value) {
    if($value==true){
        $isChecked[$i]='checked';
    }
    else {
        $isChecked[$i]='';
    }
    $i++;
}
//dd($isChecked)
@endphp

@section('content')
<div>
    <div class='text-2xl text-center'>{{$employee->name}}</div>
    <div>
        <form class="p-2" action="/admin/employees/{{$employee->id}}" method="POST">
            @csrf
            <div class="m-2">
                <label for="name" >Jméno</label>
                <input type="text" name="name" class="border border-gray-200 rounded p-2 w-full " value='{{$employee->name}}'>
            </div>
            <div class="m-2">
                <label for="email" >Email</label>
                <div class="border border-gray-200 rounded w-full flex flex-row justify-between"><input type="email" name="email" class="w-full p-2 rounded-l" value='{{$employee->email}}'><a class='w-min p-2 bg-laravel rounded-r' href='mailto:{{$employee->email}}'>Napsat</a></div>
                
            </div>
            <div class="m-2">
                <label for="phone" >Telefon</label>
                <div class="border border-gray-200 rounded w-full flex flex-row justify-between"><input type="phone" name="phone" class="w-full p-2 rounded-l" value='{{$employee->phone}}'><a class='w-min p-2 bg-laravel rounded-r' href='tel:{{$employee->phone}}'>Zavolat</a></div>
            </div>
            @foreach($sites as $key=>$site)
                <label for="{{$site['uri']}}"> {{$site['name']}}</label>
                <input type="checkbox" name="{{$site['uri']}}" {{$isChecked[$key]}}>
            @endforeach
            <input type="submit" value="Uložit">
        </form>
    </div>
</div>
@endsection
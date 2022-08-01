@extends('layout')

@section('title')
 Order Created   
@endsection

@section('content')
    <div>
        Objednávka číslo {{$order['id']}} byla vyvořena
    </div>   
@endsection
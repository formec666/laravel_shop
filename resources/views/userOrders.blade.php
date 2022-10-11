@extends('layout')

@php
 $statuses=[['0','Nová', true, 'blue-500', 'Přijmout', 'blue-600', 'blue-700'],
[ '1','Přijato', true, 'orange-500', 'Začít připravovat', 'orange-600', 'orange-700'],
['2' ,'Připravuje se', true, 'amber-500', 'Připraveno',  'amber-600', 'amber-700'],
['3' ,'Připraveno', true, 'yellow-500', 'Odeslat',  'yellow-600', 'yellow-700'],
['4' ,'Na cestě', true, 'lime-500', 'Předat',  'lime-600', 'lime-700'],
['5' ,'Předáno', false, 'green-500', 'Archivovat',  'green-600', 'green-700'],
['6' ,'Stornováno', false, 'slate-500', 'Archivovat',  'slate-600', 'slate-700']];   
@endphp

@section('title')
 Moje Objednávky   
@endsection


@section('content')
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
            placeholder="Vyhledat objednávku"
        />
        <div class="absolute top-2 right-2">
            <button
                type="submit"
                class="h-10 w-20 text-white rounded-lg bg-laravel hover:bg-gold"
            >
                Vyhledat
            </button>
        </div>
    </div>
</form>
<form action=''>

</form>

<div class="text-center text-3xl">
    Objednávky
</div>
    @foreach ($data['orders'] as $order)
    <div class='flex flex-col portrait:flex-col landscape:flex-row flex-nowrap justify-between border-4 rounded-md border-slate-400 m-2'>
        <div class='flex landscape:w-1/5 flex-row landscape:flex-col justify-between p-6 font-bold uppercase text-2xl bg-laravel'>
            <div>{{$order['id']}} </div>
            <div>{{$statuses[$order['status']][1]}}</div>
        </div>
        <div class='flex flex-row p-6 flex-wrap justify-between'>
            <div>
                <div class='font-light'>Jméno a příjmení</div>
                <div class='font-medium'>{{$order['name']}}</div>
            
                <div class='font-light'>Adresa</div>
                <div class='font-medium'>{{$order['address']}}</div>
                
                <div class='font-light'>Vytvořeno</div>
                <div class='font-medium'>{{$order['created_at']}}</div>
                
            </div>
            <div>
                @if (isset($order['invoiceName']))
                  <div class='font-light'>Jméno a příjmení na fakturu</div>
                <div class='font-medium'>{{$order['invoiceName']}}</div>  
                @endif
                @if (isset($order['invoiceAddress']))
                  <div class='font-light'>Adresa na fakturu</div>
                <div class='font-medium'>{{$order['invoiceAddress']}}</div>  
                @endif
                
                
                
                
            </div>
            <div>
                
                <div class='font-light'>Změněno</div>
                <div class='font-medium'>{{$order['updated_at']}}</div>

                <div class='font-light'>Platba</div>                
                @php
                    if ($order->payment_method=='Dobírka' or $order->payment_method=='post') {
                        
                        echo("<div class='font-medium text-black-600'>Dobírka</div>");
                                
                    }
                    else {
                        $stripe= new \Stripe\StripeClient(env('STRIPE_KEY'));
                        switch ($stripe->checkout->sessions->retrieve($order->payment_method)->payment_status) {
                            case 'unpaid':
                                echo("<div class='font-medium text-red-600'>Nezaplaceno</div>");
                                break;
                            case 'paid':
                                echo("<div class='font-medium text-green-600'>Zaplaceno</div>");
                                break;
                        }
                    }
                @endphp
                
                
            </div>
            
        </div>
        <div>
        <div class='flex flex-col  p-6 flex-wrap justify-start bg-amber-100 border-3 border-slate-300'>
           
           @foreach(json_decode($order['cart']) as $item)
            <div class='flex flex-row  flex-wrap justify-between border-y-2'>
                <div class='flex flex-row flex-wrap justify-start'>
                    <div class='font-bold text-red-500'>
                        {{$item->amount}} × 
                    </div>
                    <div class='flex flex-row'>
                        {{$item->product->name}} <div class='font-light'> ({{$item->product->id}}, {{$item->product->price}} Kč)</div>
                    </div>
                </div>
                <div class='font-bold'>
                    {{$item->product->price*$item->amount}} Kč
                </div>

            </div>
           @endforeach
            
        </div>

        <div class='border-t-2 border-slate-700 font-bold text-xl align-left bg-amber-200 flex-row flex justify-end'>
            Celkem: {{$order['total']}} Kč
        </div></div>
    </div>   
    @endforeach
    <div class="text-center text-3xl">
        Z archivu
    </div>
    @foreach ($data['archived'] as $order)
    <div class='flex flex-col portrait:flex-col landscape:flex-row flex-nowrap justify-between border-4 rounded-md border-slate-400 m-2'>
        <div class='flex flex-row justify-between landscape:w-1/5 p-6 font-bold uppercase text-2xl bg-slate-500'>
            <div>{{$order['status']}} </div>
            
        </div>
        <div class='flex flex-row p-6 flex-wrap justify-between'>
            <div>
                <div class='font-light'>Jméno a příjmení</div>
                <div class='font-medium'>{{$order['name']}}</div>
            
                <div class='font-light'>Adresa</div>
                <div class='font-medium'>{{$order['address']}}</div>
                
                <div class='font-light'>Archivováno</div>
                <div class='font-medium'>{{$order['created_at']}}</div>
                
            </div>
            <div>
                @if (isset($order['invoiceName']))
                  <div class='font-light'>Jméno a příjmení na fakturu</div>
                <div class='font-medium'>{{$order['invoiceName']}}</div>  
                @endif
                @if (isset($order['invoiceAddress']))
                  <div class='font-light'>Adresa na fakturu</div>
                <div class='font-medium'>{{$order['invoiceAddress']}}</div>  
                @endif
                
                
                
                
            </div>
            <div>
                
            <div class='font-light'>Zaměstnancem</div>
            <div class='font-medium'>{{$order['archived_by']}}</div>
            @if($archive==true)
            <div>
                <a href="archive/{{$order['id']}}">
                <button class='bg-white border-2 p-2 font active:bg-slate-200 text-lg font-bold rounded-md border-green-500 text-green-500 hover:text-green-700 hover:border-green-700'>
                    <i></i> Aktivovat
                </button></a>
            </div>
            @endif
                
                
            </div>
            
        </div>
        <div>
        <div class='flex flex-col  p-6 flex-wrap justify-start bg-amber-100 border-3 border-slate-300'>
           
           @foreach(json_decode($order['cart']) as $item)
            <div class='flex flex-row  flex-wrap justify-between border-y-2'>
                <div class='flex flex-row flex-wrap justify-start'>
                    <div class='font-bold text-red-500'>
                        {{$item->amount}} × 
                    </div>
                    <div class='flex flex-row'>
                        {{$item->product->name}} <div class='font-light'> ({{$item->product->id}}, {{$item->product->price}} Kč)</div>
                    </div>
                </div>
                <div class='font-bold'>
                    {{$item->product->price*$item->amount}} Kč
                </div>

            </div>
           @endforeach
            
        </div>

        <div class='border-t-2 border-slate-700 font-bold text-xl align-left bg-amber-200 flex-row flex justify-end'>
            Celkem: {{$order['total']}} Kč
        </div></div>
    </div>      
    @endforeach
@endsection
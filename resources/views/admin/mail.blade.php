<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta id ="meta_token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="images/favicon.ico" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            laravel: "#AC9255",
                        },
                    },
                },
            };
        </script>
    </head>
<body>
    <nav style="display: flex; 
    overflow-x: auto; 
    margin-bottom: 1rem; 
    flex-wrap: nowrap; 
    justify-content: space-between; 
    align-items: center; ">
    <a href="/ " style="align-items: center; ">
        <img class="width: 48" src="/img/logo.jpg" alt="" class="logo"/>
    </a>
    </nav>
    <main style=" padding:6px">
        <h1 style="font-size: 1.5rem; line-height: 2rem; text-align: center;">
            Vaše objednávka byla vytvořena
        </h1>
        <h2 style="padding:6px; font-size: 1.25rem;
        line-height: 1.75rem; ">
            
        </h2>
        <h2 style="font-size: 1.25rem; text-align: center;
        line-height: 1.75rem; ">
            Vytvořili jsme objednávku č. {{$order->id}} kterou již brzy odešleme zákazníkovi {{$order->name}} na adresu {{$order->address}}
        </h2>
        <ul style="padding: 6px; text-align: center; ">
            @foreach (json_decode($order->cart) as $item)
                <li>{{$item->amount}}x {{$item->product->name}} ({{$item->product->price*$item->amount}}Kč)</li>
            @endforeach
        </ul>
        <h2 style="font-size: 1.25rem; text-align: center;
        line-height: 1.75rem; ">
           Celková cena činní {{$order->total}} Kč
        </h2>
        @if ($url)
            <button><a href={{$url}}> Zaplatit obědnávku</a></button>
        @else
            Způsob platby: {{$payment}}
        @endif
        
    </main>
</body>
</html>
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
        <title>Auris @yield('title')</title>
    </head>
    <body >
        <nav class="flex flex-nowrap portrait:flex-col overflow-x-auto justify-between items-center mb-4 ">
            <a href="/ " class=" items-center"
                ><img class="w-48" src="/img/logo.jpg" alt="" class="logo"
            /></a>
            <ul class="flex  landscape:space-x-6 landscape:mr-6 text-lg items-center portrait:flex-col portrait:space-y-4">
            
              
              
                @auth
                  @if (auth()->user()->isAdmin==true)
                  <li class="">
                    <a href="/admin" >administrace</a>
                  </li>
                  @endif
                <li class="portrait:hidden">
                  <span class="font-bold uppercase">
                Vítejte {{auth()->user()->name}}
                  </span>
                </li>
      <li>
        <a href="/order/users" class="hover:text-laravel items-center"><i class="fa-solid fa-gear"></i> Vaše objednávky</a>
      </li>
      <li>
        <form  method="get" action="/logout">
          @csrf
          <button type="submit">
            <i class="fa-solid fa-door-closed"></i> Odhlásit se
          </button>
        </form>
      </li>
      @else
      <li>
        <a href="/register" class="hover:text-laravel"><i class="fa-solid fa-user-plus"></i> Registrovat se</a>
      </li>
      <li>
        <a href="/login" class="hover:text-laravel"><i class="fa-solid fa-arrow-right-to-bracket"></i> Přihlásit se </a>
      </li>
      @endauth
      <li>
        <a href="/cart/show" class="hover:text-laravel">
          <i class="fa-solid fa-shopping-cart"></i>
        </a>
      </li>
            </ul>

        
        </nav>
        

        

        <main>
            
                @yield('content')
        </div>
        </main>
        <footer
        class="  w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 justify-evenly"
    >
        <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>

        <a
            href="/login"
            class=" bg-black text-white py-2 px-5"
            >Log In</a
        >
    </footer>
    <x-flash-message />
    </body>
</html>
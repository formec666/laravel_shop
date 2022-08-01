@extends('layout')

@section('title')
Register
@endsection

@section('content')
 <div class="mx-4">
    <div
        class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24"
    >
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Registrujte se
            </h2>
            <p class="mb-4">Vytvořte si účet a mějte přístup ke svým objednávkám</p>
        </header>
        @if ($isAdmin==true)
        <form action="/admin/employees" method="POST"> 
        @else
        <form action="/createuser" method="POST">    
        @endif
        
            @csrf
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">
                    Jméno
                </label>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name"
                />
                @error('name')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2"
                    >Email</label
                >
                <input
                    type="email"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="email"
                />
                @error('email')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
                
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2"
                    >Telefonní číslo</label
                >
                <input
                    type="tel"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="phone"
                />
                @error('tel')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
                
            </div>

            <div class="mb-6">
                <label
                    for="password"
                    class="inline-block text-lg mb-2"
                >
                    Heslo
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password"
                />
                @error('password')
                 <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>   
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="password2"
                    class="inline-block text-lg mb-2"
                >
                    Potvrzení hesla
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password_confirmation"
                />
            </div>

            <div class="mb-6">
                <button
                    type="submit"
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Vytvořit účet
                </button>
            </div>

            <div class="mt-8">
                <p>
                    Už máte účet?
                    <a href="login" class="text-laravel"
                        >Přihlásit</a
                    >
                </p>
            </div>
        </form>
    </div>
</div>   
@endsection

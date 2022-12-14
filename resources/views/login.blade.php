@extends("layout")

@section('title')
Login
@endsection

@section('content')
    

<header class="text-center">
    <h2 class="text-2xl font-bold uppercase mb-1">Login</h2>
    <p class="mb-4">Přihlaste se a mějte přehled o svých objednávkách</p>
  </header>

  <form method="POST" action="/authenticate" class="p-6">
    @csrf

    <div class="mb-6">
      <label for="email" class="inline-block text-lg mb-2">Email</label>
      <input type="email" class="border border-gray-200 rounded p-2 w-full" name="email" value="{{old('email')}}" />

      @error('email')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="password" class="inline-block text-lg mb-2">
        Heslo
      </label>
      <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password"
        value="{{old('password')}}" />

      @error('password')
      <p class="text-red-500 text-xs mt-1">{{$message}}</p>
      @enderror
    </div>

    <div class="mb-6">
      <button type="submit" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
        Přihlásit
      </button>
    </div>

    <div class="mt-8">
      <p>
        Nemáte účet?
        <a href="/register" class="text-laravel">Registrovat se</a>
      </p>
    </div>
  </form>
  @endsection
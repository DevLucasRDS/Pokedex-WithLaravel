<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Pokédex</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @if(auth()->check())
            <!-- Navbar para usuários logados -->
           <header class="p-3 text-bg-dark">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('pokedex.index') }}" class="d-flex align-items-center text-white text-decoration-none me-3">
                                Home
                            </a>
                            <a href="{{ route('listar') }}" class="d-flex align-items-center text-white text-decoration-none me-3">
                                Listar
                            </a>
                            <a href="{{ route('teams.index') }}" class="d-flex align-items-center text-white text-decoration-none me-3">
                                Teams
                            </a>
                        </div>
                        <div class="d-flex align-items-center">

                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-warning" type="submit">Logout</button>
                            </form>

                        </div>
                    </div>
                </div>
            </header>
        @else
            <!-- Navbar para visitantes -->
            <header class="p-3 text-bg-dark">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('pokedex.index') }}" class="d-flex align-items-center text-white text-decoration-none me-3">
                                Home
                            </a>
                            <a href="{{ route('listar') }}" class="d-flex align-items-center text-white text-decoration-none me-3">
                                Listar
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            <a class="btn btn-outline-light me-2" href="{{ route('login') }}">Login</a>
                            <a class="btn btn-warning" href="{{ route('register') }}">Sign-up</a>
                        </div>
                    </div>
                </div>
            </header>
        @endif

        <div class="container mt-4">
            @yield('content')
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Pokedex</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @if(auth()->check())
            <!-- Navbar para usuários logados -->
            <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
                <div class="container-fluid">
                    <a class="navbar-brand text-white" href="{{ route('dashboard') }}">Pokedex</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-warning" type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        @else
            <!-- Navbar para visitantes -->
            <header class="p-3 text-bg-dark">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('index') }}" class="d-flex align-items-center text-white text-decoration-none me-3">
                                Home
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

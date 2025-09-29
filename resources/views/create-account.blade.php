@extends('layouts.app') @section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label class="form-label" for="nome">Nome</label>
                    <input
                        type="text"
                        name="nome"
                        id="nome"
                        class="form-control"
                        value="{{ old('nome') }}"
                        placeholder="Digite o seu nome"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="sobrenome">Sobrenome</label>
                    <input
                        type="text"
                        name="sobrenome"
                        id="sobrenome"
                        class="form-control"
                        value="{{ old('sobrenome') }}"
                        placeholder="Digite o seu sobrenome"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="trainer_name"
                        >Nome de Treinador</label
                    >
                    <input
                        type="text"
                        name="trainer_name"
                        id="trainer_namer"
                        class="form-control"
                        value="{{ old('trainer_name') }}"
                        placeholder="Digite o nome de treinador"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="Digite seu email"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Senha</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Digite sua senha"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password_confirmation"
                        >Confirme sua senha</label
                    >
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        placeholder="Confirme sua senha"
                        required
                    />
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-info btn-sm">
                        Criar conta
                    </button>
                </div>

                @if (session('success'))
                <span class="txt_success"> {{ session("success") }} </span>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

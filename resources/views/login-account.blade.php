@extends('layouts.app') @section('content')

<!-- formulario de login -->
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        <form action="{{ route('auth') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label class="form-label" for="login">Email ou Nome</label>
                    <input
                        type="text"
                        name="login"
                        id="login"
                        class="form-control"
                        value=""
                        placeholder="Digite seu email ou nome"
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
                        value=""
                    />
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-info btn-sm">
                        Login
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

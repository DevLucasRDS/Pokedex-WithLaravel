@extends('layouts.app') @section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
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
                        value=""
                        placeholder="Digite o nome da conta"
                    />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        value=""
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

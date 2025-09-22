@extends('layouts.admin') @section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        <form action="">
            <div class="row">
                <div class="col-md-3 col-sm-12">
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
                <div class="col-md-3 col-sm-12">
                    <label class="form-label" for="data_inicio"
                        >Data inicio</label
                    >
                    <input
                        type="date"
                        name="data_inicio"
                        id="data_inicio"
                        class="form-control"
                        value=""
                    />
                </div>
                <div class="col-md-3 col-sm-12">
                    <label class="form-label" for="data_fim">Data final</label>
                    <input
                        type="date"
                        name="data_fim"
                        id="data_fim"
                        class="form-control"
                        value=""
                    />
                </div>
                <div class="col-md-3 col-sm-12 mt-3 pt-3">
                    <button type="submit" class="btn btn-info btn-sm">
                        Pesquisar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

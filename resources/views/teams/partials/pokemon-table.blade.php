<table class="table table-striped table-hover text-center align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>HP</th>
            <th>Atk</th>
            <th>Def</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pokemons as $pokemon)
          <tr class="pokemon-row"
    data-id="{{ $pokemon->id }}"
    data-nome="{{ $pokemon->nome }}"
    data-img="{{ $pokemon->imagem }}">
    <td><img src="{{ $pokemon->imagem }}"> {{ $pokemon->id }}</td>
    <td>{{ $pokemon->nome }}</td>
    <td>{{ $pokemon->tipo }}</td>
    <td>{{ $pokemon->hp }}</td>
    <td>{{ $pokemon->attack }}</td>
    <td>{{ $pokemon->defense }}</td>
</tr>

        @endforeach
    </tbody>
</table>

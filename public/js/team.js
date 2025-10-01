document.addEventListener("DOMContentLoaded", () => {
    const slots = document.querySelectorAll(".team-slot");
    const pokemonRows = document.querySelectorAll(".pokemon-row");

    // Função para atualizar slot
    function togglePokemon(slot, id, nome, img) {
        if (slot.querySelector("input").value === id) {
            slot.innerHTML = `<span class="placeholder">Slot ${
                slot.dataset.slot * 1 + 1
            }</span>
                              <input type="hidden" name="team_pokemons[]" value="">`;
        } else {
            slot.innerHTML = `<img src="${img}" ><br>
                              <strong>${nome}</strong>
                              <input type="hidden" name="team_pokemons[]" value="${id}">`;
        }
    }

    // Clicar em Pokémon da lista
    pokemonRows.forEach((row) => {
        row.addEventListener("click", () => {
            const id = row.dataset.id;
            const nome = row.dataset.nome;
            const img = row.dataset.img;

            // Verifica se já está no time
            let existente = Array.from(slots).find(
                (s) => s.querySelector("input").value === id
            );
            if (existente) {
                togglePokemon(existente, id, nome, img); // remove
                return;
            }

            // Primeiro slot vazio
            let vazio = Array.from(slots).find(
                (s) => s.querySelector("input").value === ""
            );
            if (vazio) togglePokemon(vazio, id, nome, img);
        });
    });

    // Clicar no slot para remover Pokémon
    slots.forEach((slot) => {
        slot.addEventListener("click", () => {
            const id = slot.querySelector("input").value;
            if (id) togglePokemon(slot, id, "", "");
        });
    });
});

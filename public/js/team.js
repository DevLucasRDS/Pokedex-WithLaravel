// resources/js/team.js
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("filter-form");
    const tableContainer = document.getElementById("pokemon-table");
    const slotsContainer = document.getElementById("team-slots");

    function togglePokemon(slot, id, nome, img) {
        // mantém o input name="team_pokemons[]" em todas as situações
        if (!slot) return;
        const slotIndex = parseInt(slot.dataset.slot, 10) + 1;
        if (slot.querySelector('input[name="team_pokemons[]"]').value === id) {
            slot.innerHTML = `<span class="placeholder">Slot ${slotIndex}</span>
                              <input type="hidden" name="team_pokemons[]" value="">`;
            return;
        }
        slot.innerHTML = `<img src="${img}"><br>
                          <strong>${nome}</strong>
                          <input type="hidden" name="team_pokemons[]" value="${id}">`;
    }

    // Delegação: clique dentro da tabela de pokémons
    tableContainer.addEventListener("click", (e) => {
        const row = e.target.closest(".pokemon-row");
        if (!row) return;

        const id = row.dataset.id;
        const nome = row.dataset.nome;
        const img = row.dataset.img;

        // encontra slot já com esse id (se houver)
        const slots = Array.from(document.querySelectorAll(".team-slot"));
        const existente = slots.find(
            (s) => s.querySelector('input[name="team_pokemons[]"]').value === id
        );

        if (existente) {
            togglePokemon(existente, id, nome, img); // remove
            return;
        }

        // coloca no primeiro vazio
        const vazio = slots.find(
            (s) => s.querySelector('input[name="team_pokemons[]"]').value === ""
        );
        if (vazio) togglePokemon(vazio, id, nome, img);
    });

    // Delegação: clique nos slots para remover
    slotsContainer.addEventListener("click", (e) => {
        const slot = e.target.closest(".team-slot");
        if (!slot) return;
        const input = slot.querySelector('input[name="team_pokemons[]"]');
        if (input && input.value) {
            togglePokemon(slot, input.value, "", "");
        }
    });

    // AJAX: intercepta submit do form de filtros e busca a partial
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        // coletar parâmetros do filtro
        const params = new URLSearchParams(new FormData(form));

        // ADICIONA os pokémons selecionados nos slots como team_pokemons[] (para manter estado se o backend precisar)
        document
            .querySelectorAll('#team-slots input[name="team_pokemons[]"]')
            .forEach((inp) => {
                // adiciona mesmo que vazio (será ''), mas OK
                params.append("team_pokemons[]", inp.value);
            });

        const urlBase = form.action || window.location.href;
        const fetchUrl =
            urlBase + (params.toString() ? "?" + params.toString() : "");

        try {
            const res = await fetch(fetchUrl, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            });
            if (!res.ok) throw new Error("Network response was not ok");
            const html = await res.text();
            tableContainer.innerHTML = html;
            // NÃO precisa rebind — delegação cuida dos cliques
        } catch (err) {
            console.error("Erro ao carregar pokémons:", err);
            alert("Erro ao carregar pokémons. Veja o console.");
        }
    });
    const clearBtn = document.getElementById("clear-filters");
    const clear = clearBtn.closest("form");

    clearBtn.addEventListener("click", function () {
        // limpa os campos de busca
        clear.querySelector('input[name="name"]').value = "";
        clear.querySelector('select[name="type1"]').selectedIndex = 0;
        clear.querySelector('select[name="type2"]').selectedIndex = 0;

        // se você também quiser limpar os pokémons selecionados dos filtros:
        clear
            .querySelectorAll('input[name="team_pokemons[]"]')
            .forEach((input) => input.remove());
    });

    document.querySelectorAll(".btnDelete").forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // precisa dos parênteses ✅

            var deleteId = this.getAttribute("data-delete-id");

            Swal.fire({
                title: "Certeza?",
                text: "Você não conseguirá reverter isso!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#d33",
                confirmButtonText: "Excluir",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("formExcluir" + deleteId).submit();
                }
            });
        });
    });
});

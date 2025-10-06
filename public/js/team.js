// resources/js/team.js
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("filter-form");
    const tableContainer = document.getElementById("pokemon-table");
    const slotsContainer = document.getElementById("team-slots");
    const teamStatus = document.getElementById("team-status"); // elemento p/ status

    if (!slotsContainer) {
        console.warn("team-slots não encontrado na página.");
    }
    // Pega o input dentro dos slots
    const getSlotHiddenInput = (slot) => {
        return (
            slot.querySelector('input[type="hidden"][name^="team_pokemons"]') ||
            slot.querySelector('input[type="hidden"]')
        );
    };
    // Reseta o slot para placeholder
    function resetSlotToPlaceholder(slot) {
        const index = parseInt(slot.dataset.slot, 10) + 1;
        slot.innerHTML = `
            <span class="placeholder">Slot ${index}</span>
            <input type="hidden" name="team_pokemons[]" value="">
        `;
    }
    // Preenche o slot com o pokémon
    function fillSlot(slot, id, nome, img) {
        slot.innerHTML = `
            <img src="${img}" alt="${nome}"><br>
            <strong>${nome}</strong>
            <input type="hidden" name="team_pokemons[]" value="${id}">
        `;
    }
    // Animação de borda
    function flashSlot(slot, color) {
        slot.style.border = `3px solid ${color}`;
        setTimeout(() => {
            slot.style.border = "";
        }, 600);
    }
    // Toast com SweetAlert2
    function showToast(message, icon = "success") {
        if (typeof Swal !== "undefined") {
            Swal.fire({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                icon,
                title: message,
            });
        } else {
            console.log(message);
        }
    }
    // Atualiza o status do time
    function updateStatus() {
        const slots = Array.from(document.querySelectorAll(".team-slot"));
        const filled = slots.filter((s) => {
            const inp = getSlotHiddenInput(s);
            return inp && inp.value !== "";
        }).length;

        const remaining = slots.length - filled;
        if (teamStatus) {
            teamStatus.textContent = `Você já escolheu ${filled}/6 pokémons. Faltam ${remaining}.`;
        }
    }
    // Adiciona ou remove o pokémon do slot
    function togglePokemon(slot, id, nome, img) {
        if (!slot) return;
        const hidden = getSlotHiddenInput(slot);
        const slots = Array.from(document.querySelectorAll(".team-slot"));
        let filled = slots.filter((s) => {
            const inp = getSlotHiddenInput(s);
            return inp && inp.value !== "";
        }).length;

        filled = filled + 1;
        // Se ja estiver no slot, remove, se não, adiciona. Mensagem de alerta
        if (hidden && hidden.value === String(id)) {
            resetSlotToPlaceholder(slot);
            flashSlot(slot, "red");
            showToast("Pokémon removido do time!", "error");
        } else {
            fillSlot(slot, id, nome, img);
            flashSlot(slot, "green");
            showToast(`${nome} adicionado ao time!, ${filled}/6`, "success");
        }
        updateStatus();
    }

    // clique em linhas da tabela
    document.addEventListener("click", (e) => {
        const row = e.target.closest(".pokemon-row");
        if (!row) return;
        if (!tableContainer || !tableContainer.contains(row)) return;

        const id = row.dataset.id;
        const nome = row.dataset.nome;
        const img = row.dataset.img;

        if (!id) return;

        const slots = Array.from(document.querySelectorAll(".team-slot"));
        const existente = slots.find((s) => {
            const input = getSlotHiddenInput(s);
            return input && input.value !== "" && input.value === String(id);
        });

        if (existente) {
            togglePokemon(existente, id, nome, img); // remove
            return;
        }

        const vazio = slots.find((s) => {
            const input = getSlotHiddenInput(s);
            return !input || input.value === "" || input.value === null;
        });

        if (vazio) togglePokemon(vazio, id, nome, img);
    });

    // clique nos slots para remover
    if (slotsContainer) {
        slotsContainer.addEventListener("click", (e) => {
            const slot = e.target.closest(".team-slot");
            if (!slot) return;
            const input = getSlotHiddenInput(slot);
            if (input && input.value) {
                togglePokemon(slot, input.value, "", "");
            }
        });
    }

    // AJAX filtros
    if (form && tableContainer) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const params = new URLSearchParams(new FormData(form));

            document
                .querySelectorAll(
                    '#team-slots input[type="hidden"][name^="team_pokemons"]'
                )
                .forEach((inp) => {
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
            } catch (err) {
                console.error("Erro ao carregar pokémons:", err);
                alert("Erro ao carregar pokémons (veja console).");
            }
        });
    }

    // botão limpar filtros
    const clearBtn = document.getElementById("clear-filters");
    if (clearBtn) {
        clearBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const parentForm = clearBtn.closest("form");
            if (!parentForm) return;
            parentForm
                .querySelectorAll('input[type="text"][name="name"]')
                .forEach((i) => (i.value = ""));
            parentForm
                .querySelectorAll('select[name="type1"], select[name="type2"]')
                .forEach((s) => (s.selectedIndex = 0));
        });
    }

    // delete com sweetalert
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btnDelete");
        if (!btn) return;
        e.preventDefault();
        const deleteId = btn.getAttribute("data-delete-id");

        if (typeof Swal !== "undefined") {
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
                    const form = document.getElementById(
                        "formExcluir" + deleteId
                    );
                    if (form) form.submit();
                }
            });
        } else {
            const form = document.getElementById("formExcluir" + deleteId);
            if (form) form.submit();
        }
    });

    // inicia status
    updateStatus();
});

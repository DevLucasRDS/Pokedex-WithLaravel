document.addEventListener("DOMContentLoaded", () => {
    const img = document.getElementById("pokemon-img");
    const btn = document.getElementById("shiny-toggle");

    const normalSrc = img.src;
    //Pega a Imagem do pokémon por ID
    const shinySrc = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/shiny/${btn.dataset.id}.png`;

    let isShiny = false;

    //Alterna a imagem entre normal e shiny
    btn.addEventListener("click", () => {
        if (isShiny) {
            img.src = normalSrc;
            btn.textContent = "Shiny";
        } else {
            img.src = shinySrc;
            btn.textContent = "Normal";
        }
        isShiny = !isShiny;
    });
});

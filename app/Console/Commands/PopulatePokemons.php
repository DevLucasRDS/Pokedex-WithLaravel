<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;

class PopulatePokemons extends Command
{
    protected $signature = 'pokemons:populate';
    protected $description = 'Popula a tabela de Pokémons';

    public function handle()
    {
        $this->info('Buscando lista de Pokémons...');

        //$limit = 1000;//
        $response = Http::get("https://pokeapi.co/api/v2/pokemon");
        //?limit={$limit}"//
        if ($response->failed()) {
            $this->error('Erro ao buscar Pokémons!');
            return 1;
        }

        $results = $response->json()['results'];

        foreach ($results as $result) {
            $pokeData = Http::get($result['url'])->json();

            // Extrair os stats corretamente
            $stats = collect($pokeData['stats'])->mapWithKeys(fn($stat) => [
                $stat['stat']['name'] => $stat['base_stat']
            ]);

            Pokemon::updateOrCreate(
                ['id' => $pokeData['id']], // Usa o ID oficial da PokeAPI
                [
                    'nome'             => ucfirst($pokeData['name']),
                    'tipo'             => implode(', ', array_map(fn($t) => $t['type']['name'], $pokeData['types'])),
                    'altura'           => $pokeData['height'],
                    'peso'             => $pokeData['weight'],
                    'hp'               => $stats['hp'] ?? null,
                    'attack'           => $stats['attack'] ?? null,
                    'defense'          => $stats['defense'] ?? null,
                    'special_attack'   => $stats['special-attack'] ?? null,
                    'special_defense'  => $stats['special-defense'] ?? null,
                    'speed'            => $stats['speed'] ?? null,
                    'habilidades'      => array_map(fn($h) => $h['ability']['name'], $pokeData['abilities']),
                    'imagem'           => $pokeData['sprites']['front_default'] ?? null,
                ]
            );

            $this->info("Pokémon {$pokeData['name']} salvo!");
        }

        $this->info('Todos os Pokémons foram populados com sucesso!');
        return 0;
    }
}

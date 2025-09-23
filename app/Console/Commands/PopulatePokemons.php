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

        $limit = 1000; // Total de pokémons que deseja buscar
        $response = Http::get("https://pokeapi.co/api/v2/pokemon?limit={$limit}");

        if ($response->failed()) {
            $this->error('Erro ao buscar Pokémons!');
            return 1;
        }

        $results = $response->json()['results'];

        foreach ($results as $result) {
            $pokeData = Http::get($result['url'])->json();

            Pokemon::updateOrCreate(
                ['id' => $pokeData['id']], // Evita duplicados
                [
                    'nome' => ucfirst($pokeData['name']),
                    'tipo' => implode(', ', array_map(fn($t) => $t['type']['name'], $pokeData['types'])),
                    'altura' => $pokeData['height'],
                    'peso' => $pokeData['weight'],
                    'status' => collect($pokeData['stats'])->mapWithKeys(fn($stat) => [
                        $stat['stat']['name'] => $stat['base_stat']
                    ])->toArray(),
                    'habilidades' => array_map(fn($h) => $h['ability']['name'], $pokeData['abilities']),
                    'imagem' => $pokeData['sprites']['front_default'] ?? null,
                ]
            );

            $this->info("Pokémon {$pokeData['name']} salvo!");
        }

        $this->info('Todos os Pokémons foram populados com sucesso!');
        return 0;
    }
}

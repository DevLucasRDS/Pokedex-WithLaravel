<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Pokemon;

//Comando para popular a tabela de Pokémons
class PopulatePokemons extends Command
{
    protected $signature = 'pokemons:populate'; //comando para rodar o script
    protected $description = 'Popula a tabela de Pokémons de forma otimizada';

    //roda o comando
    public function handle()
    {
        $this->info('Buscando lista de Pokémons...');

        $limit = 1025;
        $batchSize = 50; // processa 50 de cada vez

        //Busca a lista de Pokémons
        $response = Http::timeout(30)->get("https://pokeapi.co/api/v2/pokemon?limit={$limit}");
        if ($response->failed()) {
            $this->error('Erro ao buscar lista de Pokémons!');
            return 1;
        }


        //Pega o resultado e divide em lotes para otimizar o processo
        $results = $response->json()['results'];
        $total = count($results);
        $this->info("Total de Pokémons encontrados: {$total}");
        $chunks = array_chunk($results, $batchSize);
        //Processa cada lote
        foreach ($chunks as $index => $batch) {
            $this->info("Processando lote " . ($index + 1) . "/" . count($chunks));
            //Para cada Pokémon no lote, busca os detalhes e salva no banco
            foreach ($batch as $result) {
                $pokeData = Cache::remember("pokemon_{$result['name']}", now()->addDays(1), function () use ($result) {
                    return Http::retry(3, 5000)->timeout(30)->get($result['url'])->json();
                });
                $stats = collect($pokeData['stats'])->mapWithKeys(fn($stat) => [
                    $stat['stat']['name'] => $stat['base_stat']
                ]);
                //Salva o Pokémon no banco
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
                        'habilidades'      => implode(', ', array_map(fn($h) => $h['ability']['name'], $pokeData['abilities'])),
                        'imagem'           => $pokeData['sprites']['front_default'] ?? null,
                    ]
                );

                $this->info("Pokémon {$pokeData['name']} salvo!");
            }
        }

        $this->info('Todos os Pokémons foram populados com sucesso!');
        return 0;
    }
}

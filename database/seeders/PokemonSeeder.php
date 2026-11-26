<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
    public function run(): void
    {
        $pokemons = [
            [
                'nome' => 'Bulbassauro',
                'tipo' => 'Grama',
                'imagem' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png',
                'poderes' => ['Folha Cortante', 'Golpe de Cauda', 'Fotossíntese'],
                'fraquezas' => ['Fogo', 'Gelo', 'Veneno', 'Voador'],
            ],
            [
                'nome' => 'Charmander',
                'tipo' => 'Fogo',
                'imagem' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png',
                'poderes' => ['Brasão', 'Chama', 'Lança-Chamas'],
                'fraquezas' => ['Água', 'Rocha'],
            ],
            [
                'nome' => 'Squirtle',
                'tipo' => 'Água',
                'imagem' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png',
                'poderes' => ['Bolha', 'Ataque de Cauda', 'Jato d’Água'],
                'fraquezas' => ['Elétrico', 'Grama'],
            ],
            [
                'nome' => 'Pikachu',
                'tipo' => 'Elétrico',
                'imagem' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png',
                'poderes' => ['Investida', 'Choque do Trovão', 'Relâmpago'],
                'fraquezas' => ['Terra'],
            ],
            [
                'nome' => 'Geodude',
                'tipo' => 'Rocha',
                'imagem' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/74.png',
                'poderes' => ['Soco de Pedra', 'Terremoto'],
                'fraquezas' => ['Água', 'Grama', 'Gelo', 'Luta'],
            ],
            [
                'nome' => 'Abra',
                'tipo' => 'Psíquico',
                'imagem' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/63.png',
                'poderes' => ['Confusão', 'Teleporte'],
                'fraquezas' => ['Inseto', 'Fantasma', 'Sombrio'],
            ],
        ];

        foreach ($pokemons as $pokemon) {
            Pokemon::create($pokemon);
        }
    }
}

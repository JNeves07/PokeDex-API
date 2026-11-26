<?php

namespace Tests\Feature;

use App\Models\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PokemonApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_listagem_paginada_retorna_pokemons(): void
    {
        Pokemon::create(['nome' => 'Pikachu', 'tipo' => 'Elétrico']);
        Pokemon::create(['nome' => 'Bulbassauro', 'tipo' => 'Grama']);

        $resposta = $this->getJson('/api/pokemons?per_page=1');

        $resposta->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'nome', 'tipo', 'imagem', 'poderes', 'fraquezas'],
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'per_page', 'total'],
            ])
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonPath('meta.total', 2)
            ->assertJsonCount(1, 'data');
    }

    public function test_criacao_valida_e_persiste_pokemon(): void
    {
        $dados = [
            'nome' => 'Charmander',
            'tipo' => 'Fogo',
            'imagem' => 'https://example.com/charmander.png',
            'poderes' => ['Brasão', 'Chama'],
            'fraquezas' => ['Água', 'Rocha'],
        ];

        $resposta = $this->postJson('/api/pokemons', $dados);

        $resposta->assertCreated()
            ->assertJsonPath('data.nome', 'Charmander')
            ->assertJsonPath('data.poderes.0', 'Brasão');

        $this->assertDatabaseHas('pokemons', ['nome' => 'Charmander', 'tipo' => 'Fogo']);
    }

    public function test_criacao_rejeita_dados_invalidos(): void
    {
        $resposta = $this->postJson('/api/pokemons', [
            'nome' => '',
            'tipo' => '',
            'imagem' => 'nao-e-url',
        ]);

        $resposta->assertUnprocessable()
            ->assertJsonValidationErrors(['nome', 'tipo', 'imagem'])
            ->assertJsonPath('errors.nome.0', 'O nome do Pokémon é obrigatório.');
    }

    public function test_busca_por_nome_ou_tipo(): void
    {
        Pokemon::create(['nome' => 'Pikachu', 'tipo' => 'Elétrico']);
        Pokemon::create(['nome' => 'Raichu', 'tipo' => 'Elétrico']);
        Pokemon::create(['nome' => 'Bulbassauro', 'tipo' => 'Grama']);

        $porNome = $this->getJson('/api/pokemons?q=pika');
        $porTipo = $this->getJson('/api/pokemons?tipo=grama');

        $porNome->assertOk()->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.nome', 'Pikachu');
        $porTipo->assertOk()->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.nome', 'Bulbassauro');
    }

    public function test_exibicao_atualizacao_e_exclusao(): void
    {
        $pokemon = Pokemon::create([
            'nome' => 'Squirtle',
            'tipo' => 'Água',
            'poderes' => ['Bolha'],
        ]);

        $this->getJson("/api/pokemons/{$pokemon->id}")
            ->assertOk()
            ->assertJsonPath('data.nome', 'Squirtle');

        $this->patchJson("/api/pokemons/{$pokemon->id}", [
            'nome' => 'Squirtle Aquático',
            'fraquezas' => ['Elétrico'],
        ])->assertOk()
            ->assertJsonPath('data.nome', 'Squirtle Aquático')
            ->assertJsonPath('data.fraquezas.0', 'Elétrico');

        $this->deleteJson("/api/pokemons/{$pokemon->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Pokémon excluído com sucesso.');

        $this->assertDatabaseMissing('pokemons', ['id' => $pokemon->id]);
    }

    public function test_recurso_inexistente_retorna_404_com_mensagem(): void
    {
        $this->getJson('/api/pokemons/9999')
            ->assertNotFound()
            ->assertJsonPath('message', 'Pokémon não encontrado.');
    }

    public function test_pagina_web_esta_disponivel(): void
    {
        $this->get('/pokemons')
            ->assertOk()
            ->assertSee('Pokédex Laravel');
    }
}

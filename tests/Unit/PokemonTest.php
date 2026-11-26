<?php

namespace Tests\Unit;

use App\Models\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PokemonTest extends TestCase
{
    use RefreshDatabase;

    public function test_casts_de_listas_e_scope_de_busca(): void
    {
        Pokemon::create([
            'nome' => 'Gengar',
            'tipo' => 'Fantasma',
            'poderes' => ['Sombras', 'Presa Noturna'],
            'fraquezas' => ['Terra', 'Sombrio'],
        ]);

        $pokemon = Pokemon::firstOrFail();

        $this->assertSame(['Sombras', 'Presa Noturna'], $pokemon->poderes);
        $this->assertSame(['Terra', 'Sombrio'], $pokemon->fraquezas);
        $this->assertCount(1, Pokemon::search('fantasma')->get());
        $this->assertCount(0, Pokemon::search('%')->get());
    }
}

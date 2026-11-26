<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePokemonRequest;
use App\Http\Requests\UpdatePokemonRequest;
use App\Http\Resources\PokemonResource;
use App\Models\Pokemon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PokemonController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $filtros = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'tipo' => ['nullable', 'string', 'max:50'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ], [
            'q.max' => 'A busca deve ter no máximo 100 caracteres.',
            'tipo.max' => 'O filtro de tipo deve ter no máximo 50 caracteres.',
            'per_page.integer' => 'per_page deve ser um número inteiro.',
            'per_page.min' => 'per_page deve ser no mínimo 1.',
            'per_page.max' => 'per_page deve ser no máximo 50.',
        ]);

        $pokemons = Pokemon::query()
            ->search($filtros['q'] ?? null)
            ->byTipo($filtros['tipo'] ?? null)
            ->orderBy('id')
            ->paginate((int) ($filtros['per_page'] ?? 15))
            ->withQueryString();

        return PokemonResource::collection($pokemons);
    }

    public function store(StorePokemonRequest $request): JsonResponse
    {
        $pokemon = Pokemon::create($request->validated());

        return PokemonResource::make($pokemon)
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $pokemon): PokemonResource|JsonResponse
    {
        $registro = Pokemon::find($pokemon);

        if (! $registro) {
            return $this->notFound();
        }

        return new PokemonResource($registro);
    }

    public function update(UpdatePokemonRequest $request, int $pokemon): PokemonResource|JsonResponse
    {
        $registro = Pokemon::find($pokemon);

        if (! $registro) {
            return $this->notFound();
        }

        $registro->update($request->validated());

        return new PokemonResource($registro->refresh());
    }

    public function destroy(int $pokemon): JsonResponse
    {
        $registro = Pokemon::find($pokemon);

        if (! $registro) {
            return $this->notFound();
        }

        $registro->delete();

        return response()->json(['message' => 'Pokémon excluído com sucesso.']);
    }

    private function notFound(): JsonResponse
    {
        return response()->json(['message' => 'Pokémon não encontrado.'], 404);
    }
}

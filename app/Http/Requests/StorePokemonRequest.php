<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePokemonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'tipo' => ['required', 'string', 'max:50'],
            'imagem' => ['nullable', 'url', 'max:255'],
            'poderes' => ['nullable', 'array', 'max:10'],
            'poderes.*' => ['string', 'max:100'],
            'fraquezas' => ['nullable', 'array', 'max:10'],
            'fraquezas.*' => ['string', 'max:50'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do Pokémon é obrigatório.',
            'nome.max' => 'O nome deve ter no máximo 100 caracteres.',
            'tipo.required' => 'O tipo do Pokémon é obrigatório.',
            'tipo.max' => 'O tipo deve ter no máximo 50 caracteres.',
            'imagem.url' => 'A imagem deve ser uma URL válida.',
            'poderes.array' => 'Poderes devem ser enviados como lista.',
            'poderes.max' => 'Informe no máximo 10 poderes.',
            'fraquezas.array' => 'Fraquezas devem ser enviadas como lista.',
            'fraquezas.max' => 'Informe no máximo 10 fraquezas.',
        ];
    }
}

<?php

namespace App\Http\Requests;

class UpdatePokemonRequest extends StorePokemonRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $regras = parent::rules();

        foreach (['nome', 'tipo'] as $campo) {
            array_unshift($regras[$campo], 'sometimes');
        }

        return $regras;
    }
}

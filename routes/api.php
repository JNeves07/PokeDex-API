<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::prefix('pokemons')->group(function () {
    Route::get('/', [PokemonController::class, 'index']);
    Route::post('/', [PokemonController::class, 'store']);

    Route::get('/{pokemon}', [PokemonController::class, 'show'])->whereNumber('pokemon');
    Route::match(['put', 'patch'], '/{pokemon}', [PokemonController::class, 'update'])
        ->whereNumber('pokemon');
    Route::delete('/{pokemon}', [PokemonController::class, 'destroy'])->whereNumber('pokemon');
});

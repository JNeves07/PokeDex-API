<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/pokemons');

Route::view('/pokemons', 'pokemons.index')->name('pokemons.index');

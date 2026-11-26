<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    /**
     * "Pokemon" é irregular em inglês; o plural padrão do Eloquent não se aplica.
     *
     * @var string
     */
    protected $table = 'pokemons';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'tipo',
        'imagem',
        'poderes',
        'fraquezas',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'poderes' => 'array',
            'fraquezas' => 'array',
        ];
    }

    /**
     * Busca por nome ou tipo. Os caracteres curinga do LIKE são escapados.
     */
    public function scopeSearch(Builder $query, ?string $termo): Builder
    {
        if (blank($termo)) {
            return $query;
        }

        $termo = '%'.addcslashes(trim($termo), '%_\\').'%';

        return $query->where(function (Builder $q) use ($termo) {
            $q->where('nome', 'like', $termo)
                ->orWhere('tipo', 'like', $termo);
        });
    }

    /**
     * Filtra por tipo exato (comparação sem distinção de maiúsculas no SQLite).
     */
    public function scopeByTipo(Builder $query, ?string $tipo): Builder
    {
        if (blank($tipo)) {
            return $query;
        }

        return $query->whereRaw('lower(tipo) = lower(?)', [trim($tipo)]);
    }
}

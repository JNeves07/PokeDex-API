# Pokédex Laravel

Versão moderna e estruturada da Pokédex que originalmente era um aplicativo .NET MAUI com SQLite. O código original foi extraído e preservado em [`assets/original/`](assets/original) (incluindo `Pokedex.zip`), enquanto este projeto reimplementa o domínio em **PHP 8.4 + Laravel 12**, com API REST, Eloquent, validação, testes automatizados, Docker e GitHub Actions.

## Tecnologias

- **PHP 8.4**
- **Laravel 12** (Eloquent, Form Requests, Resources, Blade, Artisan)
- **SQLite** (`database/database.sqlite`) para execução local
- **REST API** com paginação, filtros e validação
- **Docker** / Docker Compose (opcional)
- **GitHub Actions** (PHPUnit via `php artisan test`)
- **PHPUnit** com `RefreshDatabase`

## Arquitetura

```
app/
├── Http/
│   ├── Controllers/PokemonController.php
│   ├── Requests/{StorePokemonRequest,UpdatePokemonRequest}.php
│   └── Resources/PokemonResource.php
└── Models/Pokemon.php
database/
├── migrations/2024_01_01_000000_create_pokemons_table.php
└── seeders/{DatabaseSeeder,PokemonSeeder}.php
routes/api.php          # API REST
routes/web.php          # Página Blade responsiva
resources/views/        # Layout + lista de Pokémon
tests/                  # Testes Feature e Unit
assets/original/        # ZIP e fontes .NET MAUI originais
```

O modelo `Pokemon` mantém os campos do app original (`nome`, `tipo`, `imagem` e poderes) e adiciona `fraquezas`, ambos armazenados como JSON e convertidos automaticamente em arrays pelo Eloquent. A busca usa *query scopes* com escape de caracteres curinga do `LIKE`.

## Instalação

```bash
composer install
cp .env.example .env
php artisan key:generate

# Cria o arquivo SQLite se ele ainda não existir
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"

php artisan migrate --seed
php artisan serve
```

A aplicação fica disponível em <http://localhost:8000/pokemons>.

### Docker (opcional)

```bash
docker compose up --build
```

O contêiner instala as dependências, gera a chave da aplicação, roda migrações e seed e expõe a aplicação na porta `8000`.

## Endpoints da API

Base URL: `/api`

| Método | Rota | Descrição |
|---|---|---|
| `GET` | `/pokemons` | Lista paginada. Filtros: `q`, `tipo`, `per_page` (1–50) |
| `GET` | `/pokemons/{id}` | Detalhes de um Pokémon |
| `POST` | `/pokemons` | Cria um Pokémon |
| `PUT`\|`PATCH` | `/pokemons/{id}` | Atualiza um Pokémon |
| `DELETE` | `/pokemons/{id}` | Exclui um Pokémon |

Exemplo de payload:

```json
{
  "nome": "Pikachu",
  "tipo": "Elétrico",
  "imagem": "https://example.com/pikachu.png",
  "poderes": ["Investida", "Relâmpago"],
  "fraquezas": ["Terra"]
}
```

Respostas de erro usam status `422` com detalhes por campo e status `404` com mensagem clara quando o registro não existe.

## Migrações e seed

- `php artisan migrate` cria a tabela `pokemons`.
- `php artisan db:seed` insere seis Pokémon de exemplo (com tipos, poderes e fraquezas).
- `php artisan migrate:fresh --seed` recria o banco do zero.

## Testes

```bash
php artisan test
```

Os testes usam SQLite em memória (`DB_DATABASE=:memory:`) e o trait `RefreshDatabase`. A suíte cobre listagem paginada, criação, validação, busca por nome/tipo, exibição, atualização, exclusão, 404 e a página Blade.

## CI

O workflow [`.github/workflows/ci.yml`](.github/workflows/ci.yml) instala PHP 8.4 com `setup-php`, executa `composer install`, prepara o `.env` e roda `php artisan test` em cada push e pull request.

## Licença

MIT.

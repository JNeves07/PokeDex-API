using SQLite;
using Pokedex.Models;

namespace Pokedex.Data;

public class PokedexDatabase
{
    private SQLiteAsyncConnection? _db;

    private async Task Init()
    {
        if (_db is not null) return;

        var caminho = Path.Combine(FileSystem.AppDataDirectory, "pokedex.db3");
        _db = new SQLiteAsyncConnection(caminho);
        await _db.CreateTableAsync<Pokemon>();
    }

    public async Task<List<Pokemon>> ListarAsync()
    {
        await Init();
        return await _db!.Table<Pokemon>().ToListAsync();
    }

    public async Task<int> SalvarAsync(Pokemon p)
    {
        await Init();
        return p.Id == 0 ? await _db!.InsertAsync(p) : await _db!.UpdateAsync(p);
    }

    public async Task<int> ExcluirAsync(Pokemon p)
    {
        await Init();
        return await _db!.DeleteAsync(p);
    }
}

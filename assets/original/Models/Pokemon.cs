using SQLite;

namespace Pokedex.Models;

public class Pokemon
{
    [PrimaryKey, AutoIncrement]
    public int Id { get; set; }

    public string Nome { get; set; } = "";
    public string Tipo { get; set; } = "";
    public string Imagem { get; set; } = "";   // URL da imagem

    // Salvo no banco como texto separado por vírgula
    public string PoderesTexto { get; set; } = "";

    // Lista de poderes (não vai para o banco)
    [Ignore]
    public List<string> Poderes
    {
        get => PoderesTexto
            .Split(',', StringSplitOptions.RemoveEmptyEntries | StringSplitOptions.TrimEntries)
            .ToList();
        set => PoderesTexto = string.Join(", ", value);
    }
}

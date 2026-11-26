using Pokedex.Data;
using Pokedex.Models;

namespace Pokedex;

public partial class MainPage : ContentPage
{
    private readonly PokedexDatabase _db;

    public MainPage(PokedexDatabase db)
    {
        InitializeComponent();
        _db = db;
    }

    protected override async void OnAppearing()
    {
        base.OnAppearing();
        await CarregarAsync();
    }

    private async Task CarregarAsync()
    {
        PokemonsView.ItemsSource = await _db.ListarAsync();
    }

    private async void OnSalvarClicked(object sender, EventArgs e)
    {
        if (string.IsNullOrWhiteSpace(NomeEntry.Text) || string.IsNullOrWhiteSpace(TipoEntry.Text))
        {
            await DisplayAlert("Atenção", "Informe pelo menos nome e tipo.", "OK");
            return;
        }

        var pokemon = new Pokemon
        {
            Nome = NomeEntry.Text.Trim(),
            Tipo = TipoEntry.Text.Trim(),
            Imagem = ImagemEntry.Text?.Trim() ?? "",
            PoderesTexto = PoderesEntry.Text?.Trim() ?? ""
        };

        await _db.SalvarAsync(pokemon);

        NomeEntry.Text = TipoEntry.Text = ImagemEntry.Text = PoderesEntry.Text = "";
        await CarregarAsync();
    }

    private async void OnExcluirClicked(object sender, EventArgs e)
    {
        if (sender is Button { CommandParameter: Pokemon p })
        {
            await _db.ExcluirAsync(p);
            await CarregarAsync();
        }
    }
}

# Pokédex .NET MAUI

Aplicativo simples de Pokédex feito com .NET MAUI e SQLite.

## Funcionalidades
- Cadastro de Pokémon (nome, tipo, imagem e lista de poderes)
- Listagem dos Pokémon cadastrados
- Exclusão de registros
- Armazenamento local em banco SQLite

## Estrutura
- `Models/Pokemon.cs`: classe do modelo
- `Data/PokedexDatabase.cs`: acesso ao banco
- `MainPage.xaml` e `MainPage.xaml.cs`: tela principal
- `MauiProgram.cs`: configuração e injeção de dependência

## Pacotes NuGet
- sqlite-net-pcl
- SQLitePCLRaw.bundle_green

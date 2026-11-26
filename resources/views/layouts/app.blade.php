<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pokédex Laravel')</title>
    <style>
        :root { color-scheme: light; --primary: #dc0a2d; --bg: #f6f8fa; --card: #fff; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background: var(--bg); color: #24292f; }
        header { background: var(--primary); color: #fff; padding: 1.25rem 1rem; text-align: center; }
        header h1 { margin: 0; font-size: 1.6rem; }
        header p { margin: .25rem 0 0; opacity: .9; }
        .container { max-width: 1100px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
        .panel { background: var(--card); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .form-grid { display: grid; gap: .75rem; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); }
        label { display: block; font-size: .85rem; font-weight: 600; margin-bottom: .25rem; }
        input { width: 100%; padding: .6rem .7rem; border: 1px solid #d0d7de; border-radius: 8px; font: inherit; }
        button { border: 0; border-radius: 8px; padding: .65rem 1rem; font: inherit; cursor: pointer; background: var(--primary); color: #fff; font-weight: 600; }
        button.secondary { background: #57606a; }
        button.danger { background: #cf222e; padding: .45rem .8rem; font-size: .85rem; }
        .row { display: flex; flex-wrap: wrap; gap: .75rem; align-items: end; }
        .row > div { flex: 1 1 190px; }
        .grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); }
        .card { background: var(--card); border-radius: 12px; padding: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,.06); display: flex; gap: .9rem; }
        .card img { width: 72px; height: 72px; object-fit: contain; }
        .card h2 { font-size: 1.05rem; margin: 0 0 .3rem; }
        .tag { display: inline-block; background: #f0f3f6; border-radius: 999px; padding: .15rem .55rem; font-size: .75rem; margin: 0 .25rem .25rem 0; }
        .meta { font-size: .78rem; color: #57606a; }
        .actions { margin-top: auto; }
        .error { color: #cf222e; font-size: .85rem; margin-top: .5rem; }
        footer { text-align: center; color: #57606a; font-size: .85rem; padding: 1rem; }
        @media (max-width: 600px) { .card img { width: 56px; height: 56px; } }
    </style>
</head>
<body>
    <header>
        <h1>Pokédex Laravel</h1>
        <p>Cadastre, busque e explore Pokémon — PHP 8.4 + Laravel 12</p>
    </header>
    <main class="container">
        @yield('content')
    </main>
    <footer>Projeto de estudo — API REST · Eloquent · SQLite</footer>
</body>
</html>

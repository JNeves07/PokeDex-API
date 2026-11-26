@extends('layouts.app')

@section('title', 'Pokédex — Lista de Pokémon')

@section('content')
    <section class="panel">
        <h2>Buscar</h2>
        <form id="form-busca" class="row">
            <div>
                <label for="busca">Nome ou tipo</label>
                <input id="busca" name="q" type="search" placeholder="Ex.: Pikachu ou Fogo">
            </div>
            <div>
                <button type="submit">Buscar</button>
                <button type="button" class="secondary" id="limpar-busca">Limpar</button>
            </div>
        </form>
    </section>

    <section class="panel">
        <h2>Novo Pokémon</h2>
        <form id="form-pokemon" class="form-grid">
            <div>
                <label for="nome">Nome *</label>
                <input id="nome" name="nome" required maxlength="100">
            </div>
            <div>
                <label for="tipo">Tipo *</label>
                <input id="tipo" name="tipo" required maxlength="50">
            </div>
            <div>
                <label for="imagem">URL da imagem</label>
                <input id="imagem" name="imagem" type="url" placeholder="https://...">
            </div>
            <div>
                <label for="poderes">Poderes (separados por vírgula)</label>
                <input id="poderes" name="poderes" placeholder="Investida, Relâmpago">
            </div>
            <div>
                <label for="fraquezas">Fraquezas (separadas por vírgula)</label>
                <input id="fraquezas" name="fraquezas" placeholder="Terra, Rocha">
            </div>
            <div>
                <button type="submit">Salvar Pokémon</button>
            </div>
        </form>
        <p class="error" id="erro" hidden></p>
    </section>

    <p class="meta" id="total"></p>
    <div class="grid" id="lista" aria-live="polite">Carregando Pokémon...</div>

    <script>
        const lista = document.getElementById('lista');
        const erro = document.getElementById('erro');
        const total = document.getElementById('total');

        function escapar(valor) {
            return String(valor ?? '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
            })[c]);
        }

        function listaParaArray(valor) {
            if (Array.isArray(valor)) return valor;
            if (!valor) return [];
            return String(valor).split(',').map((item) => item.trim()).filter(Boolean);
        }

        function cartao(pokemon) {
            const poderes = listaParaArray(pokemon.poderes)
                .map((p) => `<span class="tag">${escapar(p)}</span>`).join('');
            const fraquezas = listaParaArray(pokemon.fraquezas)
                .map((f) => `<span class="tag">${escapar(f)}</span>`).join('');
            const imagem = pokemon.imagem
                ? `<img src="${escapar(pokemon.imagem)}" alt="${escapar(pokemon.nome)}">`
                : '';

            return `<article class="card">
                ${imagem}
                <div style="flex:1">
                    <h2>#${pokemon.id} ${escapar(pokemon.nome)}</h2>
                    <span class="tag">${escapar(pokemon.tipo)}</span>
                    <div class="meta">Poderes: ${poderes || '—'}</div>
                    <div class="meta">Fraquezas: ${fraquezas || '—'}</div>
                    <div class="actions"><button class="danger" data-excluir="${pokemon.id}">Excluir</button></div>
                </div>
            </article>`;
        }

        async function carregar(q = '') {
            erro.hidden = true;
            try {
                const resposta = await fetch(`/api/pokemons?q=${encodeURIComponent(q)}`, {
                    headers: { Accept: 'application/json' }
                });
                if (!resposta.ok) throw new Error('Não foi possível carregar os Pokémon.');
                const dados = await resposta.json();
                lista.innerHTML = dados.data.length
                    ? dados.data.map(cartao).join('')
                    : '<p>Nenhum Pokémon encontrado.</p>';
                total.textContent = `Total: ${dados.meta.total} registro(s)`;
            } catch (e) {
                lista.innerHTML = '<p>Não foi possível carregar os Pokémon.</p>';
            }
        }

        document.getElementById('form-busca').addEventListener('submit', (event) => {
            event.preventDefault();
            carregar(document.getElementById('busca').value);
        });

        document.getElementById('limpar-busca').addEventListener('click', () => {
            document.getElementById('busca').value = '';
            carregar();
        });

        document.getElementById('form-pokemon').addEventListener('submit', async (event) => {
            event.preventDefault();
            const corpo = {
                nome: document.getElementById('nome').value,
                tipo: document.getElementById('tipo').value,
                imagem: document.getElementById('imagem').value || null,
                poderes: listaParaArray(document.getElementById('poderes').value),
                fraquezas: listaParaArray(document.getElementById('fraquezas').value)
            };

            try {
                const resposta = await fetch('/api/pokemons', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
                    body: JSON.stringify(corpo)
                });
                const dados = await resposta.json();
                if (!resposta.ok) {
                    erro.textContent = dados.message ?? 'Erro ao salvar Pokémon.';
                    erro.hidden = false;
                    return;
                }
                event.target.reset();
                await carregar();
            } catch (e) {
                erro.textContent = 'Erro de comunicação com a API.';
                erro.hidden = false;
            }
        });

        lista.addEventListener('click', async (event) => {
            const botao = event.target.closest('[data-excluir]');
            if (!botao) return;
            if (!confirm('Excluir este Pokémon?')) return;

            const resposta = await fetch(`/api/pokemons/${botao.dataset.excluir}`, {
                method: 'DELETE',
                headers: { Accept: 'application/json' }
            });
            if (resposta.ok) {
                await carregar(document.getElementById('busca').value);
            }
        });

        carregar();
    </script>
@endsection

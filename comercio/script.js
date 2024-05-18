// Função para carregar produtos
function carregarProdutos() {
    // Fazer requisição AJAX para buscar produtos do servidor
    fetch('produto.php')
        .then(response => response.json())
        .then(produtos => {
            const produtosContainer = document.getElementById('produtos');

            produtos.forEach(produto => {
                const produtoElement = document.createElement('div');
                produtoElement.classList.add('produtos');

                const imagem = document.createElement('img');
                imagem.src = produto.imagem; // Incluir link para a imagem do produto
                produtoElement.appendChild(imagem);

                const nome = document.createElement('h3');
                nome.textContent = produto.nome;
                produtoElement.appendChild(nome);

                const preco = document.createElement('p');
                preco.textContent = `R$ ${produto.preco}`;
                produtoElement.appendChild(preco);

                const botaoAdicionar = document.createElement('button');
                botaoAdicionar.textContent = 'Adicionar ao Carrinho';
                botaoAdicionar.dataset.produtoId = produto.id;
                botaoAdicionar.addEventListener('click', adicionarProdutoAoCarrinho);
                produtoElement.appendChild(botaoAdicionar);

                produtosContainer.appendChild(produtoElement);
            });
        });
}

// Função para adicionar produto ao carrinho
function adicionarProdutoAoCarrinho(event) {
    const button = event.target;
    const productId = button.dataset.productId;

    // Fazer requisição AJAX para adicionar produto ao carrinho no servidor
    fetch('adicionarProdutoAoCarrinho.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `produto_id=${productId}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                atualizarCarrinho(); // Atualizar a exibição do carrinho
                alert('Produto adicionado ao carrinho!');
            } else {
                alert('Erro ao adicionar produto: ' + data.error);
            }
        });
}

// Função para atualizar a exibição do carrinho
function atualizarCarrinho() {
    // Fazer requisição AJAX para buscar itens do carrinho no servidor
    fetch('obterCarrinho.php')
        .then(response => response.json())
        .then(itensCarrinho => {
            const carrinhoConteudo = document.getElementById('carrinho-conteudo');
            carrinhoConteudo.innerHTML = ''; // Limpar o conteúdo antigo

            if (itensCarrinho.length === 0) {
                carrinhoConteudo.innerHTML = '<p>O carrinho está vazio.</p>';
            } else {
                let totalCarrinho = 0;

                itensCarrinho.forEach(item => {
                    const itemElement = document.createElement('li');
                    itemElement.innerHTML = `
                        ${item.nome} x ${item.quantidade} - R$ ${item.precoTotal}
                    `;
                    carrinhoConteudo.appendChild(itemElement);

                    totalCarrinho += item.precoTotal;
                });

                const totalElement = document.createElement('p');
                totalElement.innerHTML = `<strong>Total: R$ ${totalCarrinho.toFixed(2)}</strong>`;
                carrinhoConteudo.appendChild(totalElement);
            }
        });
}

// Chamar as funções para carregar produtos e atualizar o carrinho inicialmente
carregarProdutos();
atualizarCarrinho();
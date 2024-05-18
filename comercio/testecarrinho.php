<?php
// Conexão com o banco de dados (implemente a lógica de conexão)
$conn = new PDO('mysql:host=localhost;dbname=comercio', 'root', '');

// Verificação de erros na conexão
if (!$conn) {
    echo "Erro ao conectar ao banco de dados: " . $conn->errorInfo()[2];
    die();
}


class Carrinho {
    private $clienteId;
    private $produtos = [];
    private $total = 0;

    public function __construct($clienteId) {
        $this->clienteId = $clienteId;
    }

    public function adicionarProduto($produtoId, $quantidade) {
        // Consulta produto na tabela "produtos"
        $sql = "SELECT id, nome, preco FROM produtos WHERE id = :produto_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produto_id', $produtoId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $produto = $stmt->fetch(PDO::FETCH_ASSOC); // Utilize PDO::FETCH_ASSOC para um array associativo

            // Adiciona produto ao array de produtos do carrinho
            $this->produtos[] = [
                'id' => $produto['id'],
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'quantidade' => $quantidade
            ];

            // Atualiza total do valor da compra
            $this->total += $produto['preco'] * $quantidade;
        }
    }

    public function exibirHeader() {
        echo "<h3>Carrinho - {$this->clienteId}</h3>";
        echo "<ul>";
        foreach ($this->produtos as $produto) {
            echo "<li>{$produto['nome']}: {$produto['quantidade']}x R$ {$produto['preco']}</li>";
        }
        echo "</ul>";
        echo "<strong>Total: R$ {$this->total}</strong>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="carrinho.css">
</head>
<body>
    <div class="principal">
        <section>
            <img id="img" src="img/suga.jpg" alt="">
        </section>
        <section class="carrinho">
            <h1>Loja Online</h1>

            <div id="produtos">
                </div>

            <div id="carrinho">
                <h2>Carrinho</h2>
                <div id="carrinho-conteudo"></div>
                <button onclick="finalizarCompra()">Finalizar Compra</button>
            </div>

            <script src="script1.js"></script>
        </section>
    </div>
</body>
</html>
<?php
// Conexão com o banco de dados (implemente a lógica de conexão)
$conn = new PDO('mysql:host=localhost;dbname=comercio', 'root', '');

// Verificação de erros na conexão
if (!$conn) {
    echo "Erro ao conectar ao banco de dados: " . $conn->errorInfo()[2];
    die();
}

// Classe Carrinho
class Carrinho {
    private $cliente_Id;
    private $produtos = [];
    private $total = 0;

    public function __construct($cliente_Id) {
        $this->cliente_Id = $cliente_Id;
    }

    // Adiciona produto ao carrinho
    public function adicionarProduto($produto_Id, $quantidade) {
        // Consulta produto na tabela "produtos" (implemente a lógica de consulta)
        $sql = "SELECT * FROM produtos WHERE id = :produto_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produto_id', $produto_Id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $produto = $stmt->fetch();

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

    // Exibe os dados do carrinho no header
    public function exibirHeader() {
        echo "<h3>Carrinho - {$this->cliente_Id}</h3>";
        echo "<ul>";
        foreach ($this->produtos as $produto) {
            echo "<li>{$produto['nome']}: {<span class='math-inline'>produto\['quantidade'\]\}x R</span> {<span class='math-inline'>produto\['preco'\]\}</li\>";
}
echo "</ul\>";
echo "<strong\>Total\: R</span> {$this->total}</strong>";
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
    <link rel="stylesheet" href="script.js">

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
             <a href="compras.php"><button onclick="finalizarCompra()">Finalizar Compra</button></a>
        </div>

     <script src="script.js"></script>


        </section>
    </div>
</body>
</html>
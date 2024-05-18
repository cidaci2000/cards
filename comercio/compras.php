<?php
// Conexão com o banco de dados
$conn = new PDO('mysql:host=localhost;dbname=comercio', 'root', '');

// Verificação de erros na conexão
if (!$conn) {
  echo "Erro ao conectar ao banco de dados: " . $conn->errorInfo()[2];
  die();
}


// Inicializar variáveis para evitar erros indefinidos
$cliente_id = null;
$valor_total = null;
$status = 'pendente'; // Set status to 'pendente' by default

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Receber dados do cliente (implemente a validação se necessário)
  $cliente_id = filter_input(INPUT_POST, 'cliente_id', FILTER_SANITIZE_STRING);

  // Receber dados dos produtos e quantidades (implemente a lógica de processamento)
  // ... (Exemplos de como receber dados de produtos e quantidades) ...

  // Validar e processar dados de produtos e quantidades
  $produtos = []; // Array para armazenar informações de produtos
  if (isset($_POST['produto_id']) && isset($_POST['quantidade'])) {
    $produtoIds = $_POST['produto_id'];
    $quantidades = $_POST['quantidade'];

    // Validar IDs e quantidades de produtos (implemente a lógica de validação)
    // ... (Exemplos de validação de produtos e quantidades) ...

    // Loop para processar cada produto e quantidade
    for ($i = 0; $i < count($produtoIds); $i++) {
      $produto_id = $produtoIds[$i];
      $quantidade = $quantidades[$i];

      // Buscar informações do produto pelo ID (implemente a lógica de consulta)
      // ... (Exemplo de consulta para obter detalhes do produto) ...
      // $produto = /* dados do produto recuperados da consulta */;

      // Calcular subtotal para cada produto (preço unitário * quantidade)
      $subtotal = /* preço unitário do produto */  $quantidade;

      // Adicionar informações do produto e subtotal ao array $produtos
      $produtos[] = [
        'produto_id' => $produto_id,
        'quantidade' => $quantidade,
        'subtotal' => $subtotal,
      ];
    }
  }

  // Calcular valor total da compra somando subtotais de todos os produtos
  $valor_total = 0;
  foreach ($produtos as $produto) {
    $valor_total += $produto['subtotal'];
  }

  // Inserir a compra no banco de dados
  $sql = "INSERT INTO compras (cliente_id, data_hora_compra, valor_total, status) VALUES (:cliente_id, CURRENT_TIMESTAMP, :valor_total, :status)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':cliente_id', $cliente_id);
  $stmt->bindParam(':valor_total', $valor_total);
  $stmt->bindParam(':status', $status);

  if ($stmt->execute()) {
    $compra_id = $conn->lastInsertId();

    // Inserir detalhes dos produtos na compra (implemente a lógica de inserção)
    // ... (Exemplo de inserção de itens da compra na tabela apropriada) ...

    echo "Compra cadastrada com sucesso!";
  } else {
    echo "Erro ao cadastrar compra: " . $stmt->errorInfo()[2];
  }
}

// Encerra a conexão com o banco de dados
$conn = null;

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Compras</title>
    <link rel="stylesheet" href="compras.css">
</head>
<body>
    <h1>Gerenciar Compras</h1>

    <div class="container">
        <h2>Lista de Compras</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID Compra</th>
                    <th>Cliente</th>
                    <th>Data/Hora</th>
                    <th>Valor Total</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>

        <button onclick="abrirModalNovaCompra()">Nova Compra</button>
    </div>

    <div id="modalNovaCompra" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalNovaCompra()">&times;</span>
            <h2>Nova Compra</h2>

            <form action="salvarCompra.php" method="post">
                <button type="submit">Salvar Compra</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
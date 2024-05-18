<?php

// Função para validação de campos
function validarCampo($campo) {
  return !empty($campo) && trim($campo) != "";
}

// Função para converter preço para float
function converterParaFloat($preco) {
  return floatval(str_replace(",", ".", $preco));
}

// Função para upload de imagem
function uploadImagem($imagem) {
  $target_dir = "img/";
  $target_file = $target_dir . basename($imagem["name"]);

  if (!move_uploaded_file($imagem["tmp_name"], $target_file)) {
    return null;
  }

  return $target_file;
}

// Conexão com o banco de dados
$conn = new PDO('mysql:host=localhost;dbname=comercio', 'root', '');

// Verificação de envio do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Dados do formulário
  $id_produto = $_POST["id_produto"];
  $nome = $_POST["nome"];
  $descricao = $_POST["descricao"];
  $preco = converterParaFloat($_POST["preco"]);
  $categoria = $_POST["categoria"];
  $estoque = $_POST["estoque"];
  $imagem = $_FILES["img"];

  // Validação de campos
  $erros = [];
  if (!validarCampo($id_produto)) {
    $erros[] = "O campo ID do produto é obrigatório.";
  }
  if (!validarCampo($nome)) {
    $erros[] = "O campo nome é obrigatório.";
  }
  if (!validarCampo($descricao)) {
    $erros[] = "O campo descrição é obrigatório.";
  }
  if (!validarCampo($preco)) {
    $erros[] = "O campo preço é obrigatório e deve ser um número válido.";
  }
  if (!validarCampo($categoria)) {
    $erros[] = "O campo categoria é obrigatório.";
  }
  if (!validarCampo($estoque)) {
    $erros[] = "O campo estoque é obrigatório.";
  }

  if (!is_numeric($preco)) {
    $erros[] = "O campo preço deve ser um número válido.";
  }

  // Upload da imagem
  $imagem_path = null;
  if (isset($imagem) && $imagem["error"] === 0) {
    $imagem_path = uploadImagem($imagem);
    if (!$imagem_path) {
      $erros[] = "Erro ao enviar a imagem.";
    }
  }

  // Se não houver erros, cadastra o produto
  if (empty($erros)) {
    $stmt = $conn->prepare("INSERT INTO produtos (id_produto, nome, descricao, preco, categoria, estoque, imagem) VALUES (:id_produto, :nome, :descricao, :preco, :categoria, :estoque, :imagem)");
    $stmt->bindParam(':id_produto', $id_produto);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':estoque', $estoque);
    $stmt->bindParam(':imagem', $imagem_path);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      echo "<p>Produto cadastrado com sucesso!</p>";
    } else {
      echo "<p>Erro ao cadastrar o produto.</p>";
    }
  } else {
    // Exibe os erros
    echo "<ul>";
    foreach ($erros as $erro) {
      echo "<li>$erro</li>";
    }
    echo "</ul>";
  }
}

// Fecha a conexão com o banco de dados
$conn = null;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="produto.css">
  <title>Cadastro de Produto</title>
</head>
<body>
  <h1>Cadastro de Produto</h1>
  <div class="form">
    <form action="produto.php" method="post" enctype="multipart/form-data">

      <label for="id_produto">ID do Produto:</label>
      <input type="text" name="id_produto" id="id_produto" required>

      <label for="nome">Nome:</label>
      <input type="text" name="nome" id="nome" required>

      <label for="descricao">Descrição:</label>
      <textarea name="descricao" id="descricao" required></textarea>

      <label for="preco">Preço:</label>
      <input type="text" name="preco" id="preco" required>

      <label for="categoria">Categoria:</label>
      <select name="categoria" id="categoria" required>
        <option value="">Selecione...</option>
        <option value="Eletrônicos">Eletrônicos</option>
        <option value="Roupas">Roupas</option>
        <option value="Livros">Livros</option>
      </select>

      <label for="estoque">Estoque:</label>
      <input type="number" name="estoque" id="estoque" required>

      <label for="img">Imagem:</label>
      <input type="file" name="img" id="img" accept="image/*">

      <button type="submit">Enviar</button>

    </form>
  </div>
</body>
</html>



<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="card.css">
  <title>Carrossel com Cards</title>
</head>
<header>
  <H1>MODELO DE CARD</H1>

  <nav>
  <ul class="nav-list">
    <li><a href="#">Início</a></li>
    <li><a href="#">Sobre</a></li>
    <li><a href="#">Contato</a></li>
  </ul>
  </nav>
</header>

<section>

<?php

$conn = new PDO('mysql:host=localhost;dbname=comercio', 'root', '');

// Verificação de erros na conexão
if (!$conn) {
  echo "Erro ao conectar ao banco de dados: " . $conn->errorInfo()[2];
  die();
}

$sql = "SELECT id_produto, nome, preco, categoria, estoque, imagem FROM produtos";
$stmt = $conn->query($sql);

// Verificação de erros na consulta
if (!$stmt) {
  echo "Erro ao executar a consulta: " . $conn->errorInfo()[2];
  die();
}

while ($produto = $stmt->fetch()) {
  ?>
  <div class="linha">
   <div class="container">
      <div class="row">
        
        <div class="meucard">
          <div class="card">
              <a href="carrinho.php"><img id="image" src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>"></a>
              <h3><?php echo $produto['nome']; ?></h3>
              <p>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
              <p><?php echo $produto['categoria']; ?></p>
              <p>Estoque: <?php echo $produto['estoque']; ?></p>
              <p>ID: <?php echo $produto['id_produto']; ?></p>
              <a href="carrinho.php"><button class="botao-comprar">Comprar</button></a>
            </div>
            <br>
          </div>
        </div>
        </div>
    </div>
    </div>
  
  <?php
}


// Fechamento da conexão
$conn = null;

?>
<script>
  const pagination = new PaginationJS({
  el: '.container',
  items: 3, // Número de cards por página
  currentPage: 1, // Página inicial
  visiblePages: 5, // Número de páginas visíveis na navegação
});
</script>

</section>

</body>

<footer>
    <p>Copyright &copy; 2023</p> <p>USO ACADÊMICO</p>
    <ul class="redes-sociais">
      <li><a href="#"><img src="imagens/facebook.png" alt="Facebook"></a></li>
      <li><a href="#"><img src="imagens/instagram.png" alt="Instagram"></a></li>
      <li><a href="#"><img src="imagens/twitter.png" alt="Twitter"></a></li>
    </ul>
</footer>

</html>
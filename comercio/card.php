<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="card.css">
    <title>Carrossel de Produtos com Cards</title>
</head>
<body>

<header>
    <h1>MODELO DE CARD</h1>

    <nav>
        <ul class="nav-list">
            <li><a href="#">Início</a></li>
            <li><a href="#">Sobre</a></li>
            <li><a href="#">Contato</a></li>
        </ul>
    </nav>
</header>

<section class="product-carousel">
    <div class="container">
        <div class="row">
            <?php
            $conn = new PDO('mysql:host=localhost;dbname=comercio', 'root', '');

            if (!$conn) {
                echo "Erro ao conectar ao banco de dados: " . $conn->errorInfo()[2];
                die();
            }

            $sql = "SELECT id_produto, nome, preco, categoria, estoque, imagem FROM produtos";
            $stmt = $conn->query($sql);

            if (!$stmt) {
                echo "Erro ao executar a consulta: " . $conn->errorInfo()[2];
                die();
            }

            while ($produto = $stmt->fetch()) {
                ?>
                <div class="meucard">
                    <div class="card">
                        <a href="product-details.php?id=<?php echo $produto['id_produto']; ?>">
                            <img id="image" src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
                        </a>
                        <h3><?php echo $produto['nome']; ?></h3>
                        <p>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        <p><?php echo $produto['categoria']; ?></p>
                        <p>Estoque: <?php echo $produto['estoque']; ?></p>
                        <p>ID: <?php echo $produto['id_produto']; ?></p>
                        <a href="carrinho.php?action=add&id=<?php echo $produto['id_produto']; ?>">
                            <button class="botao-comprar">Comprar</button>
                        </a>
                    </div>
                </div>
                <?php
            }

            $conn = null;
            ?>
        </div>
    </div>

    <div class="pagination-container">
        <ul class="pagination"></ul>
    </div>
</section>

<footer>
    <p>Copyright &copy; 2023</p> <p>USO ACADÊMICO</p>
    <ul class="redes-sociais">
        <li><a href="#"><img src="images/facebook.png" alt="Facebook"></a></li>
        <li><a href="#"><img src="images/instagram.png" alt="Instagram"></a></li>
        <li><a href="#"><img src="images/twitter.png" alt="Twitter"></a></li>
    </ul>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.4/pagination.min.js"></script>
<script src="script.js"></script>
</body>
</html>

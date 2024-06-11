
<?php

// Conexão com o banco de dados
$conn = new PDO('mysql:host=localhost;dbname=comercio', 'root', '');

// Verificação de erros na conexão
if (!$conn) {
  echo "Erro ao conectar ao banco de dados: " . $conn->errorInfo()[2];
  die();
}
// Recebendo dados do formulário
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Validação básica do CPF (formato)
if (strlen($cpf) != 11 || !preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/', $cpf)) {
    echo "CPF inválido.";
    exit;
}

// Consulta no banco de dados
$sql = "SELECT senha FROM usuarios WHERE cpf = :cpf";
$stmt = $db->prepare($sql);
$stmt->bindParam(':cpf', $cpf);
$stmt->execute();

// Verificando se a conta existe e se a senha está correta
$usuario = $stmt->fetch();
if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    echo "CPF ou senha incorretos.";
    exit;
}

// Login bem-sucedido!
echo "Login efetuado com sucesso!";

// (Opcional) Redirecionamento para a página do carrinho ou outra página
header('Location: carrinho.php');
exit;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="login.css">
<title>Login</title>

</head>
<body>
    <div class="login-container">
        <h2>ENTRAR</h2>
        <form action="login.php" method="POST">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required maxlength="11"> <br>
            <label for="password">SENHA:</label>
            <input type="text" id="password" name="password"  required maxlength="10">
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html> 

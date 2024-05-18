<?php
// Conexão com o banco de dados
$conn = new PDO('mysql:host=localhost;dbname=comercio', 'root', '');

// Verificação de erros na conexão
if (!$conn) {
  echo "Erro ao conectar ao banco de dados: " . $conn->errorInfo()[2];
  die();
}
// Recebe os dados do formulário
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);

// Validações básicas (opcional)
$erros = []; // Array para armazenar mensagens de erro
if (empty($nome) || empty($email) || empty($cpf) || empty($endereco) || empty($cidade) || empty($estado) || empty($telefone)) {
    $erros['geral'] = "Preencha todos os campos!";
}

// Validação do nome (tamanho máximo de 50 caracteres)
if (strlen($nome) > 50) {
    $erros['nome'] = "Nome deve ter no máximo 50 caracteres";
}

// Validação do email (formato válido)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros['email'] = "E-mail inválido";
}

// Validação do CPF (formato e dígito verificador)
//if (!validaCPF($cpf)) {
    //$erros['cpf'] = "CPF inválido";
//}

// ... (outras validações opcionais) ...

// Se não houver erros, processa os dados
if (empty($erros)) {
    // Prepare a consulta SQL para inserir os dados
    $sql = "INSERT INTO cliente (nome, email, cpf, endereco, cidade, estado, telefone) VALUES (:nome, :email, :cpf, :endereco, :cidade, :estado, :telefone)";
    $stmt = $conn->prepare($sql);

    // Vincula os valores aos parâmetros da consulta
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':telefone', $telefone);

    // Executa a consulta e verifica se foi bem-sucedida
    if ($stmt->execute()) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar cliente: " . $stmt->errorInfo()[2];
    }
} else {
    // Exibe as mensagens de erro
    foreach ($erros as $campo => $mensagem) {
        echo "<p class='error'>$campo: $mensagem</p>";
    }
}

// Fecha a conexão com o banco de dados
$conn = null;

// Função para validar o CPF (implemente a lógica de acordo com suas necessidades)
function validaCPF($cpf) {
    // ... (implementação da validação de CPF) ...
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="cliente.css">
</head>
<body>
    <h1>Cadastro de Cliente</h1>
    <form action="cliente.php" method="post">
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" required> <br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required> <br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required maxlength="11"> <br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required> <br>

        <label for="cidade">Cidade:</label>
        <input type="text" id="cidade" name="cidade" required> <br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="">Selecione</option>
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AM">Amazonas</option>
            <option value="AP">Amapá</option>
            </select> <br>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required> <br>
        <label for="password">Senha:</label>
        <input type="text" id="password" name="password"  required maxlength="10">
        <label for="confirmepassword">Confirme Senha:</label>
        <input type="text" id="confirmepassword" name="confirmepassword"  required maxlength="10">
        

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
<?php
 // Conexão com o banco de dados
 require_once $_SERVER['DOCUMENT_ROOT'] . '/api/conexao/MysqliConnection.php';
 use api\conexao\MysqliConnection;
 session_start();

 $conn = MysqliConnection::getInstance()->getConnection();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecione para a página de login se não estiver autenticado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados da consulta do formulário
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    // Valide os dados da consulta conforme necessário

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Insira os dados da consulta no banco de dados (substitua com sua lógica)
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO consultas (user_id, data, horario) VALUES ('$user_id', '$data', '$horario')";

    if ($conn->query($sql) === TRUE) {
        echo "Reunião marcada com sucesso.";
    } else {
        echo "Erro ao marcar a reunião: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Marcar Reunião</title>
    <style>
        body {
            background-color: rgba(211, 211, 211, 1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        p {
            text-align: center;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <p><a href="perfil_utilizador.php">Voltar para o Perfil</a></p>
</body>
</html>

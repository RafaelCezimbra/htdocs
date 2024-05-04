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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Recupere o ID da consulta da URL
    $consulta_id = $_GET['id'];

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verifique se a consulta pertence a este usuário antes de excluí-la
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM consultas WHERE id = $consulta_id AND user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Reunião excluída com sucesso.";
    } else {
        echo "Erro ao excluir a raunião: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID de reunião não especificado.";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Excluir Reunião</title>

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

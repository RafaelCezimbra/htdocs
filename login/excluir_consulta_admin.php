<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Excluir Consulta</title>
    <style>
        body {
            background-color: rgba(211, 211, 211, 1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content">
        <?php
        // Conexão com o banco de dados
        require_once $_SERVER['DOCUMENT_ROOT'] . '/api/conexao/MysqliConnection.php';
        use api\conexao\MysqliConnection;
        session_start();
       
        $conn = MysqliConnection::getInstance()->getConnection();
       
       
       // Verifique se o usuário está autenticado como administrador
       if (!isset($_SESSION['user_id'])) {
           header("Location: index.php"); // Redirecionar para a página de login se não estiver autenticado
           exit();
       }
       
       // Verifique se o ID da consulta foi especificado na URL
       if (!isset($_GET['consulta_id'])) {
           die("ID da consulta não especificado.");
       }
       
       // Recupere o ID da consulta da URL
       $consulta_id = $_GET['consulta_id'];
       
       // Verifica a conexão
       if ($conn->connect_error) {
           die("Conexão falhou: " . $conn->connect_error);
       }
       
       // Exclua a consulta do banco de dados
       $sql = "DELETE FROM consultas WHERE id = $consulta_id";
       
       if ($conn->query($sql) === TRUE) {
           echo "Consulta excluída com sucesso. <a href='perfil_admin.php'>Voltar à página do administrador</a>";
       } else {
           echo "Erro ao excluir a consulta: " . $conn->error;
       }
       
       $conn->close();
        ?>
    </div>
</body>
</html>


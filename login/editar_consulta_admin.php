<?php
session_start();
 // Conexão com o banco de dados
 require_once $_SERVER['DOCUMENT_ROOT'] . '/api/conexao/MysqliConnection.php';
 use api\conexao\MysqliConnection;
 session_start();

 $conn = MysqliConnection::getInstance()->getConnection();

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $consulta_id = $_POST['consulta_id'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    // Atualize os dados da consulta na base de dados
    $sql_update = "UPDATE consultas SET data = '$data', horario = '$horario' WHERE id = $consulta_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Consulta atualizada com sucesso.";
    } else {
        echo "Erro na atualização: " . $conn->error;
    }
}

// Recupere as informações da consulta com base no ID
if (isset($_GET['consulta_id'])) {
    $consulta_id = $_GET['consulta_id'];

    $sql = "SELECT * FROM consultas WHERE id = $consulta_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $data = $row['data'];
        $horario = $row['horario'];
    } else {
        echo "Consulta não encontrada.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Reunião</title>
    <style>
        body {
            background-color: rgba(211, 211, 211, 1);
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            flex-direction: column;
        }

        form {
            text-align: center;
        }

        a {
            text-decoration: none;
            margin-left: 10px;
            border: 1px solid white;
            border-radius: 10px;
            padding: 5px;
            color: black;
        }

        input[type="submit"]:hover {
            background: white;
            border-radius: 10px;
            -ms-transform: scale(1.1);
            transform: scale(1.1);
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Reunião</h2>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="consulta_id" value="<?php echo $consulta_id; ?>">

            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?php echo $data; ?>" required><br><br>

            <label for="horario">Horário:</label>
            <input type="time" id="horario" name="horario" value="<?php echo $horario; ?>" required><br><br>

            <input type="submit" value="Salvar Alterações">
        </form>

        <p><a href="perfil_admin.php">Voltar a Página do Administrador</a></p>
    </div>
</body>
</html>

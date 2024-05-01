<?php
 // Conexão com o banco de dados
 require_once $_SERVER['DOCUMENT_ROOT'] . '/api/conexao/MysqliConnection.php';
 use api\conexao\MysqliConnection;
 session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecione para a página de login se não estiver autenticado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Verifique se o ID da consulta foi especificado na URL
    if (!isset($_GET['id'])) {
    //f (!isset($_POST['id'])) {
        die("ID de consulta não especificado.");
    }

    // Recupere o ID da consulta da URL
    $id_consulta = $_GET['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_consulta = $_POST['id'];
}

// Recupere os detalhes da consulta com base no ID
$user_id = $_SESSION['user_id'];

// Consulta para obter os detalhes da consulta com base no ID da consulta e no ID do usuário
$conn = MysqliConnection::getInstance()->getConnection();
$sql = "SELECT * FROM consultas WHERE id = $id_consulta AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $data = $row['data'];
    $horario = $row['horario'];
} else {
    echo "Consulta não encontrada ou não pertence a este usuário.";
    exit();
}

// Processamento do formulário de edição
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os novos dados da consulta do formulário

    $nova_data = $_POST['data'];
    $novo_horario = $_POST['horario'];
    $novo_data_hora = $nova_data . ' ' . $novo_horario;
    $conn = MysqliConnection::getInstance()->getConnection();

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $data_atual = new DateTime();
    
    $data_consulta = new DateTime($novo_data_hora);
    
    //Calcula a diferenca entre as duas datas
    $diferenca = $data_consulta->diff($data_atual);

    //Converte a diferenca de dias para hora
    $diferenca_horas = $diferenca->days*24;

    // Verificar se a diferença é menor que 72 horas (ou seja, 3 dias)
    if ($diferenca_horas < 72) {
        echo "Você não pode editar esta consulta porque já se passaram menos de 72 horas desde a data da consulta.";
        // Encerrar o script ou redirecionar o usuário para uma página de erro
        exit;
    } else {

        // Atualize os dados da consulta no banco de dados
        $sql = "UPDATE consultas SET data = '$nova_data', horario = '$novo_horario' WHERE id = $id_consulta AND user_id = '$user_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Consulta atualizada com sucesso.";
        } else {
            echo "Erro ao atualizar a consulta: " . $conn->error;
        }


        $data = $nova_data;
        $horario = $novo_horario;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Consulta</title>
    <style>
        body {
            background-color: rgba(211, 211, 211, 1);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
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
        <h2>Editar Consulta</h2>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="data">Nova Data da Consulta:</label>
            <input type="date" id="data" name="data" value="<?php echo $data; ?>" required><br><br>

            <label for="horario">Novo Horário da Consulta:</label>
            <input type="time" id="horario" name="horario" value="<?php echo $horario; ?>" required><br><br>
            <input type="text" id="data" name="id" style="display: none;" value="<?php echo $id_consulta; ?>" required><br><br>
            <input type="submit" value="Salvar Alterações">
        </form>

        <p><a href="perfil_utilizador.php">Voltar para o Perfil</a></p>
    </div>
</body>
</html>


7<?php
include("/php/api/conexao/conexao.php");
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

// Exibe o ID da consulta (apenas para fins de depuração)
echo "ID da Consulta: " . $id_consulta;


// Recupere os detalhes da consulta com base no ID
$user_id = $_SESSION['user_id'];

// Consulta para obter os detalhes da consulta com base no ID da consulta e no ID do usuário
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

$conn->close();

// Processamento do formulário de edição
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os novos dados da consulta do formulário
    $nova_data = $_POST['data'];
    $novo_horario = $_POST['horario'];

    // Valide os dados da consulta conforme necessário

    // Conecte-se ao banco de dados novamente
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Atualize os dados da consulta no banco de dados
    $sql = "UPDATE consultas SET data = '$nova_data', horario = '$novo_horario' WHERE id = $id_consulta AND user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Consulta atualizada com sucesso.";
    } else {
        echo "Erro ao atualizar a consulta: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Consulta</title>
</head>
<body>
    <h2>Editar Consulta</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="data">Nova Data da Consulta:</label>
        <input type="date" id="data" name="data" value="<?php echo $data; ?>" required><br><br>

        <label for="horario">Novo Horário da Consulta:</label>
        <input type="time" id="horario" name="horario" value="<?php echo $horario; ?>" required><br><br>
        <input type="text" id="data" name="id" value="<?php echo $id_consulta; ?>" required><br><br>
        <input type="submit" value="Salvar Alterações">
    </form>

    <p><a href="perfil_utilizador.php">Voltar para o Perfil</a></p>
</body>
</html>

<?php
session_start();

 // Conexão com o banco de dados
 require_once $_SERVER['DOCUMENT_ROOT'] . '/api/conexao/MysqliConnection.php';
 use api\conexao\MysqliConnection;
 session_start();

 $conn = MysqliConnection::getInstance()->getConnection();

// Verificar a autenticação do usuário
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redireciona para a página de login se o usuário não estiver autenticado
    exit();
}

    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password_db = "root";
    $dbname = "cpphp_ex";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Supondo que você tenha uma maneira de identificar o usuário logado (por exemplo, usando uma sessão)
$user_id = $_SESSION['user_id']; 

// Consulta para obter os dados atuais do usuário
$sql = "SELECT * FROM utilizadores WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    $row = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário de edição
    $novo_nome = $_POST['novo_nome'];
    $novo_password = $_POST['novo_password'];

    // Consulta para atualizar os dados do usuário
    $sql_update = "UPDATE utilizadores SET nome = '$novo_nome', password = '$novo_password' WHERE user_id = $user_id";
    
    if ($conn->query($sql_update) === TRUE) {
        echo '<div class="message-container">';
        echo "Dados atualizados com sucesso.";
        echo '<br><a href="perfil_utilizador.php">Voltar ao Perfil</a>';
        echo '</div>';
    } else {
        echo '<div class="message-container">';
        echo "Erro ao atualizar os dados: " . $conn->error;
        echo '</div>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
    <style>
        body {
            background-color: rgba(211, 211, 211, 1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            text-align: center;
        }
        .message-container {
            text-align: center;
            position: absolute;
            top: 50px; 
            width: 100%;
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
    <div class="form-container">
        <h2>Editar Perfil</h2>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="novo_nome">Novo Nome:</label>
            <input type="text" id="novo_nome" name="novo_nome" value="<?php echo $row['nome']; ?>" required><br><br>

            <label for="novo_password">Password:</label>
            <input type="password" id="novo_password" name="novo_password" value="<?php echo $row['password']; ?>" required><br><br>

            <input type="submit" value="Salvar Alterações">
        </form>
    </div>
</body>
</html>

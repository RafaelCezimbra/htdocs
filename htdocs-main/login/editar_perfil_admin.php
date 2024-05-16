<?php
session_start();

 // Conexão com o banco de dados
 require_once '../api/conexao/MysqliConnection.php';
 use api\conexao\MysqliConnection;
 session_start();
    $conn = MysqliConnection::getInstance()->getConnection();

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $user_id = $_POST['user_id'];
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];

    // Atualize os dados do usuário na base de dados
    $sql_update = "UPDATE utilizadores SET nome = '$nome', apelido = '$apelido', user_name = '$user_name', email = '$email' WHERE user_id = $user_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "A successful update to the user's data.";
    } else {
        echo  "Erro na atualização: " . $conn->error;
    }
}

// Recupere as informações do usuário com base no ID
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $sql = "SELECT * FROM utilizadores WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $apelido = $row['apelido'];
        $user_name = $row['user_name'];
        $email = $row['email'];
    } else {
        echo "Usuário não encontrado.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Perfil do Usuário</title>

    <style>
        label {
    color: black;
    font-size:20x;
    text-align:center;
    }
    
    body{font-family: 'Montserrat', sans-serif;
    font-size: 20px;
    background-color:#FFFAFA;
    }

    body {
    background-color: rgba(211, 211, 211, 1);
    background-repeat: no-repeat;
    background-size: 100%;
    margin:0;
    padding:0;
    }

    input[type="submit"] {
    background-color: #f8f8f8;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    }

    input[type="submit"]{
    background-color: #f8f8f8;
    border: 1px solid #ccc;
    border-radius: 10px;
    color:black;
    position: relative;
    margin-left:0%;
    font-family:bold;
    width:50%;
    }

    input[type="submit"]:hover {
    background: #ccc;
    -ms-transform: scale(1.1);
    transform: scale(1.1);
    }

    input[type="text"],input[type="email"],
    input[type="password"] {
    width: 50%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-left:20px;
    }

    input{
        font-family: 'Montserrat', sans-serif;
        font-size: 18px;
    }

    .box1{
        padding-top:3%;
        padding-bottom:3%;
        padding-left:4%;
        padding-right:4%;
        width:60%;
        margin:auto;
        margin-top: 5%;
        border-radius:50px;
        background-color: RGBA( 248, 248, 255, 1);
        display: flex; align-items: center; justify-content: center; 
    }

    form{
        margin:auto;
    }

    .return{
        padding-top: 45%;
    }

    a{
        text-decoration:none;
        color: #000080;
    }

    a:hover{
        color:#0000FF;
    }

    </style>
</head>
<body>
<div class="box1">
    <h2>Edit user profile</h2>

    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        
        <label for="nome"><b>Name:</b></label>
        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required><br><br>

        <label for="apelido"><b>Last name:</b></label>
        <input type="text" id="apelido" name="apelido" value="<?php echo $apelido; ?>" required><br><br>

        <label for="user_name"><b>User name:</b></label>
        <input type="text" id="user_name" name="user_name" value="<?php echo $user_name; ?>" required><br><br>

        <label for="email"><b>E-mail:</b></label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <input type="submit" value="Save">
    </form>
  

    <p class="return"><a href="perfil_admin.php">Return</a></p>
</div>

</body>
</html>

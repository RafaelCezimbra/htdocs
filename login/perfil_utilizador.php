<?php
 // Conexão com o banco de dados
 require_once $_SERVER['DOCUMENT_ROOT'] . '/api/conexao/MysqliConnection.php';
 use api\conexao\MysqliConnection;
 session_start();

 $conn = MysqliConnection::getInstance()->getConnection();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redireciona para a página de login se não estiver autenticado
    exit();
}




if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT nome, apelido, user_name, password  FROM utilizadores WHERE user_id = " . $_SESSION["user_id"];
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta SQL: " . $conn->error);
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nome = $row['nome'];
    $apelido = $row['apelido'];
    $user_name = $row['user_name'];
    $password = $row['password'];
} else {
    echo "Perfil de usuário não encontrado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Perfil do Utilizador</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald&display=swap');

    * {
      box-sizing: border-box;
      }

    [class*="col-"] {
      float: left;
      /* padding: 15px; */
    }  
    
    .row::after {
      content: "";
      clear: both;
      display: table;
    } 
    
    .row>* {
    padding-right: 0;
    padding-left: 0;
}


body {
    font-family: 'Montserrat', sans-serif;
    background-color: rgba(211, 211, 211, 1);
}

h1 {
  color: #30404A;
  font-family: 'Oswald', sans-serif;  
  font-size: 96px;
}

h4 {
  color: #30404A;
  font-family: 'Montserrat', sans-serif;
  font-size: 32px;
}

.caixa1.row {
  width: 60%;
  margin:auto;
  margin-top: 5%;
  border-radius:50px;
  background-color: RGBA( 248, 248, 255, 1 );
}

.col-6{
    width:40%;
}

h2 {
    color: #ffffff;
    font-family: 'Oswald', sans-serif;
}

h4 {
    color: #30404A;
    font-family: 'Montserrat', sans-serif;
    font-size: 32px;
}


.error-message {
    color: #ACD7F2;
    font-size: 24px;
    margin-top: 25px;
}
label {
    font-family: 'Oswald', sans-serif;
    font-family: bold;
    letter-spacing: 1px;
    color: black;
    font-size:12px;
}
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 3px;
}
input[type="submit"] {
    background-color: white;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin-left: 0;
}
input[type="submit"]:hover {
    background: #ccc;
    border-radius: 10px;
    -ms-transform: scale(1.1);
    transform: scale(1.1);
}
#conta {
  color: #3E4C59;
margin-top: 25px;}

form {
  /* width:50%; */
  margin: auto;
  /* background-color: #80A7BF; */
  /* padding: 50px;
  border-radius: 25px; */
  /* margin-top: 25px; */
}

button.btn.btn-primary.meu-botao {
  background-color: #FEB07D;
  border: none;
  border-radius: 10px;
  color:#000000;
  position: relative;
  margin-left:77%;
}

a#registo{
  color: #3E4C59;
  font-weight: bold;
}

.caixa1.row {
  width:60%;
  margin:auto;
  margin-top: 5%;
  border-radius:50px;
}

.col-6.area-welcome{
  padding-left:2%;
  padding-right:2%;

}

#perfil-h1{
  color:black;
  font-size: 72px;
  text-align:center;
}

#perfil-h4 {
    color:black;
    font-size: 32px;
    text-align:center;

}


.user-table {
    width: 100%;
    /* border-collapse: collapse; */
    margin-top: 20px; 
}

.user-table th, .user-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.user-table th {
    /* background-color: #f2f2f2; */
}

input.meu-botao-submit {
    background-color: rgba(0,0,0,0);
    color: #3E4C59;
    font-weight: bold;
    font-size: 16px;
    font-family: 'Montserrat', sans-serif;
    text-decoration: underline;
    float: right;
    clear: both;
    
    /* padding: 10px 20px;
    cursor: pointer; */
}

input.meu-botao-submit:hover {
    background-color: rgba(0,0,0,0);

}

#botaoSair{
  background-color: #f8f8f8;
  border: none;
  border-radius: 10px;
  color:#000000;
  padding:10px 20px;
  margin-top: 10%;
  float: right;
  clear: both;
  margin-bottom: 10px;
  
  }

  #botaoSair:hover {
    background: #ccc;
    border-radius: 10px;
    -ms-transform: scale(1.1);
    transform: scale(1.1);
}

  img{
    padding-top: 30%;
  }


    </style>
</head>
<body class="p-3 m-0 border-0 bd-example m-0 border-0">

    <h1 id="perfil-h1">Seu Perfil</h1>
    <h4 id="perfil-h4">Olá <?php echo $nome; ?>! </h4>

    <div class="caixa1 row">



<div class="col-6">




    <img src="imagens/user.jpg" alt="persona" width="100%" height="auto";>


    <?php

    // Verifique se o usuário está autenticado
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php"); // Redireciona para a página de login se não estiver autenticado
        exit();
    }

    // Recupere as informações do usuário a partir do banco de dados (substitua com a sua lógica)
    $user_id = $_SESSION['user_id'];
    $servername = "localhost";
    $username = "root";
    $password_db = "root";
    $dbname = "cpphp_ex";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "SELECT nome, apelido, user_name, email FROM utilizadores WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if (!$result) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $apelido = $row['apelido'];
        $user_name = $row['user_name'];
        $email = $row['email'];
    } else {
        echo "Perfil de usuário não encontrado.";
    }

    $conn->close();
    ?>
      </div>

<div class="col-6 area-welcome">

<h3>Os teus dados:</h3>

    <table class="user-table">
        <tr>
            <th>Nome</th>
            <th>Apelido</th>
            <th>User name</th>
            <th>Email</th>
        </tr>
        <tr>
            <td><?php echo $nome; ?></td>
            <td><?php echo $apelido; ?></td>
            <td><?php echo $user_name; ?></td>
            <td><?php echo $email; ?></td>
        </tr>
    </table>



    <p id="conta" style="text-align:right;margin-top:10%"><a id="registo" href="editar_perfil.php">Editar dados do utilizador 
      <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 256 512">
      <path d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z"/>
      </svg></a></p>

    <hr>

    <h3>Marcar Reunião:</h3>
    <form method="POST" action="marcar_consulta.php">
        <label for="data">Data da Reunião:</label>
        <input type="date" id="data" name="data" required><br><br>

        <label for="horario">Hora da Reunião:</label>
        <input type="time" id="horario" name="horario" required><br><br>

        <!-- Adicione campos para marcar consultas aqui -->
        <input type="submit" value="Marcar Reunião" class="meu-botao-submit"> 
    </form>

 




    <!-- ... seu código existente ... -->

<h3 style="margin-top:20%">Reuniões Agendadas</h3>
<table class="user-table">
    <thead>
        <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Conecte-se ao banco de dados
        $servername = "localhost";
        $username = "root";
        $password_db = "root";
        $dbname = "cpphp_ex";

        $conn = new mysqli($servername, $username, $password_db, $dbname);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Recupere as consultas agendadas do usuário
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT id, data, horario FROM consultas WHERE user_id = '$user_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $consulta_id = $row['id']; // Defina o ID da consulta
                $data = $row['data'];
                $horario = $row['horario'];

                // Exiba cada consulta agendada em uma linha da tabela
                echo "<tr>";
                echo "<td>$data</td>";
                echo "<td>$horario</td>";
                echo "<td>";
                echo "<a href='editar_consulta.php?id=$consulta_id' >Editar</a> | ";
                echo "<a href='excluir_consulta.php?id=$consulta_id'>Excluir</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhuma consulta agendada.</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>


</table>

    <a href="index.php" id="botaoSair">Logout</a>


    </div>
</body>
</html>

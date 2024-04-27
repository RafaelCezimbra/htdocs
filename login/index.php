<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/conexao/MysqliConnection.php';
use api\conexao\MysqliConnection;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $conn = MysqliConnection::getInstance()->getConnection();
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    // Consulta para verificar as credenciais do usuário
    $sql = "SELECT user_id, user_type FROM utilizadores WHERE user_name = '". $user_name . "' AND password = '" .$password . "'";
    $result = $conn->query($sql);
  

    if (!$result) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id']; // Defina a variável de sessão após a autenticação bem-sucedida

        if ($row['user_type'] === 'utilizador') {
            header("Location: perfil_utilizador.php"); // Redireciona para o perfil do utilizador
        } elseif ($row['user_type'] === 'administrador' && $user_name === 'admin' && $password === 'admin1234') {
            header("Location: perfil_admin.php"); // Redireciona para o perfil do administrador
        } else {
            $login_error = "Papel desconhecido.";
        }

        exit();
    } else {
        $login_error = "Nome de utilizador ou senha incorretos.";
    }

    $conn->close();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Sistema de login e registo de utilizadores</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
    background-image: url(imagens/img3.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}

h1 {
  color: white;
  font-family: 'Oswald', sans-serif;  
  font-size: 90px;
}

.caixa1 {
  background-color: rgba(128,128,128,0.5); 
}

.col-6{width:50%;}

h2{
    color: white;
    font-family: 'Oswald', sans-serif;
    font-size: 45px;
    text-align: center;
    margin-top: 20%;
    text-decoration: underline;
    text-shadow: 1px 2px 2px #000;
}

h3 {
    color: white;
    font-family: 'Montserrat', sans-serif;
    font-size: 20px;
}

h4{
    color: white;
    font-family: 'Montserrat', sans-serif;
    font-size: 25px;
    text-align: center;
    text-shadow: 2px 2px 2px #000;
    padding-top: 10px;
}


.error-message {
    color: #ACD7F2;
    font-size: 24px;
    margin-top: 25px;
}
label {
    color: #ffffff;
    font-size:14px;
}
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 3px;
}

#conta {
  color: white;
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
  background-color: #f8f8f8;
  border: 1px solid #ccc;
  border-radius: 10px;
  color:#808080;
  position: relative;
  margin-left:0%;
}

button.btn.btn-primary.meu-botao:hover{
  background: #ccc;
  -ms-transform: scale(1.1);
  transform: scale(1.1);
}

a#registo{
  color: white;
  font-weight: bold;
}

a#registo:hover{
  color: #ccc;
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


    </style>
  </head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0">

  <div class="caixa1 row">


  <div class="col-6">
    <h2>How can we assist you?</h2>
    <br>
    <h4>Our team will analyze and present a solution, 
      always taking into consideration the originality/investment relationship.	</h4>

  </div>

<div class="col-6 area-welcome">

  <h1 style="margin-top: 20%; text-align:center;">Welcome</h1>

  <h3>Sign in to continue</h3>

      <?php
      if (isset($login_error)) {
          echo '<p class="error-message">' . $login_error . '</p>';
      }
      ?>

      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      
      <div class="mb-3">
        <input type="text" class="user-name" id="user-name" name="user_name" required aria-describedby="emailHelp" placeholder="Username">
      </div>
      <div class="mb-3">
        <input type="password" class="password" id="password" name="password" required placeholder="Password">
      </div>

      <button type="submit" class="btn btn-primary meu-botao">Sign in</button>

      <p id="conta">Don't have an account? <a id="registo" href="pagina_de_registro.html" style="font-weight:bold">Register</a></p>

      <p id="conta" style="text-align:right;margin-top:20%"><a id="registo" href="homepage.html">Continue without login 
      <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 256 512">
      <path d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z"/>
      </svg></a></p>


    </form>
    </div>

</div>
  </body>
</html>
<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecionar para a página de login se não estiver autenticado
    exit();
}

// Processar o formulário de registro de projeto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
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

    // Obter dados do formulário
    $user_id = $_POST['user_id'];  // Certifique-se de ter um campo oculto no formulário para armazenar o ID do usuário
    $data_criacao = $_POST['data_criacao'];
    $tecnologia_associada = $_POST['tecnologia_associada'];
    $status = $_POST['status'];

    // Processar a imagem
    $image_name = $_FILES['user_image']['name'];
    $image_tmp = $_FILES['user_image']['tmp_name'];
    $image_path = "imagens/" . $image_name;

    move_uploaded_file($image_tmp, $image_path);

    // Consulta para inserir um novo projeto na tabela projetos
    $sql_insert_projeto = "INSERT INTO projetos (user_id, data_criacao, tecnologia_associada, status, imagem) 
                           VALUES ('$user_id', '$data_criacao', '$tecnologia_associada', '$status', '$image_path')";

        var_dump($sql_insert_projeto);
    if ($conn->query($sql_insert_projeto) === TRUE) {
        echo "<p>Projeto registrado com sucesso.</p>";
    } else {
        echo "Erro ao registrar projeto: " . $conn->error;
    }

    // Consulta para recuperar informações de todos os projetos
$sql_projetos = "SELECT * FROM projetos";
$result_projetos = $conn->query($sql_projetos);

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Administrador</title>

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
    background-color: #30404A;
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

.caixa1 {
  background-color: #A8D8ED;
}

.col-6{width:50%;}
.col-4{width:25%;}
.col-8{width:75%;}




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
input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
input[type="submit"]:hover {
    background-color: #0056b3;
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
  width:70%;
  margin:auto;
  margin-top: 3%;
  border-radius:50px;
}

.col-6.area-welcome{
  padding-left:2%;
  padding-right:2%;

}

#perfil-h1{
  color: #A8D8ED;
  font-size: 62px;
  text-align:center;
}

#perfil-h4 {
    color: #A8D8ED;
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
  background-color: #FEB07D;
  border: none;
  border-radius: 10px;
  color:#000000;
  padding:10px 20px;
  margin-top: 10%;
  float: right;
clear: both;
}


    </style>
</head>

<body class="p-3 m-0 border-0 bd-example m-0 border-0">

    <h1 id="perfil-h1">Administrador</h1>

    <p style="text-align:center;"><img src="imagens/img4.jpg" alt="persona" width="20%" height="auto" style="border-radius:50%;"></p>


    <div class="caixa1 row" style="padding:50px;">



    <?php
    // Conexão com o banco de dados (substitua com suas configurações)
    $servername = "localhost";
    $username = "root";
    $password_db = "root";
    $dbname = "cpphp_ex";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Consulta para recuperar informações de todos os usuários
    $sql_users = "SELECT * FROM utilizadores";
    $result_users = $conn->query($sql_users);

    if ($result_users->num_rows > 0) {
        echo "<h3>Informações de Todos os Utilizadores:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Apelido</th><th>Nome de Utilizador</th><th>E-mail</th><th>Ações</th></tr>";

        while ($row = $result_users->fetch_assoc()) {
            $user_id = $row['user_id'];
            $nome = $row['nome'];
            $apelido = $row['apelido'];
            $user_name = $row['user_name'];
            $email = $row['email'];

            echo "<tr><td>$user_id</td><td>$nome</td><td>$apelido</td><td>$user_name</td><td>$email</td>";
            echo "<td><a href='editar_perfil_admin.php?user_id=$user_id'>Editar</a> | <a href='excluir_utilizador_admin.php?user_id=$user_id'>Excluir</a></td></tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Nenhum usuário encontrado.</p>";
    }

    // Consulta para listar todas as consultas marcadas
    $sql_consultas = "SELECT * FROM consultas";
    $result_consultas = $conn->query($sql_consultas);

    if ($result_consultas->num_rows > 0) {
        echo "<h3>Consultas Marcadas:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>ID do Utilizador</th><th>Data</th><th>Horário</th><th>Ações</th></tr>";

        while ($row = $result_consultas->fetch_assoc()) {
            $consulta_id = $row['id'];
            $user_id = $row['user_id'];
            $data = $row['data'];
            $horario = $row['horario'];

            echo "<tr><td>$consulta_id</td><td>$user_id</td><td>$data</td><td>$horario</td>";
            echo "<td><a href='editar_consulta_admin.php?consulta_id=$consulta_id'>Editar</a> | <a href='excluir_consulta_admin.php?consulta_id=$consulta_id'>Excluir</a></td></tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Nenhuma consulta encontrada.</p>";
    }

    $conn->close();
    ?>



    <!-- Seção para registrar um novo projeto -->
    <h3>Registrar Novo Projeto:</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <!-- Certifique-se de incluir um campo oculto para armazenar o ID do usuário -->
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        
        <label for="data_criacao">Data de Criação:</label>
        <input type="date" id="data_criacao" name="data_criacao" required><br><br>

        <label for="tecnologia_associada">Tecnologia Associada:</label>
        <input type="text" id="tecnologia_associada" name="tecnologia_associada" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="marcado">Marcado</option>
            <option value="em_progresso">Em Progresso</option>
            <option value="terminado">Terminado</option>
        </select><br><br>

        <label for="user_image">Imagem do Projeto:</label>
        <input type="file" id="user_image" name="user_image" accept="image/*" required><br><br>

        <!-- Adicione campos adicionais conforme necessário -->

        <input type="submit" value="Registrar Projeto">
    </form>
    <!-- Fim da seção de registro de projeto -->

    <!-- Seção para exibir projetos -->
    <h3>Projetos Registrados:</h3>

    


</div>

</body>
</html>

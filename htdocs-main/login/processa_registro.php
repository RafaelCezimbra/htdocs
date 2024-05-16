<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Registrar Usuário</title>
    <style>
        body {
            background-color: rgba(211, 211, 211, 1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
        }
        #botaoSair{
            background-color: #ccc;
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
            background: #f8f8f8;
            border-radius: 10px;
            -ms-transform: scale(1.1);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // session_start();

        // Conexão com o banco de dados
        require_once '../api/conexao/MysqliConnection.php';
        use api\conexao\MysqliConnection;
        session_start();

        $conn = MysqliConnection::getInstance()->getConnection();

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Obter dados do formulário
        $nome = $_POST['nome'];
        $apelido = $_POST['apelido'];
        $user_name = $_POST['user_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Consulta para verificar se o user_name já está em uso
        $sql_check_username = "SELECT * FROM utilizadores WHERE user_name = '$user_name'";
        $result_check_username = $conn->query($sql_check_username);

        if ($result_check_username->num_rows > 0) {
            echo "Error: The username is already in use. Please choose another one.";
        } else {
            // Consulta para inserir um novo registro na tabela utilizadores
            $sql = "INSERT INTO utilizadores (nome, apelido, user_name, email, password, user_type) VALUES ('$nome', '$apelido', '$user_name', '$email', '$password', 'utilizador')";

            if ($conn->query($sql) === TRUE) {
                // Redireciona para a página de login após o registro bem-sucedido
                header("Location: index.php");
                exit(); // Certifica-se de que o script seja encerrado após o redirecionamento
            } else {
                if ($conn->errno === 1062) {
                    echo "Erro: O endereço de e-mail já está em uso. Por favor, escolha outro.";
                } else {
                    echo "Erro ao registrar: " . $conn->error;
                }
            }
        }

        $conn->close();
        ?>

        <a href="pagina_de_registro.html" id="botaoSair">Back</a>
    </div>
</body>
</html>

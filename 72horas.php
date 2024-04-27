<?php
// Verificar se a solicitação é POST (substitua isso pela lógica real de verificação de permissão do usuário)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Supondo que você tenha o ID da consulta disponível em $_POST['consulta_id']
    $consulta_id = $_POST['consulta_id'];

    // Conectar ao banco de dados (substitua com suas configurações)
    include('config.php');

    // Consulta SQL para obter a data da consulta
    $sql = "SELECT data_consulta FROM consultas WHERE consulta_id = $consulta_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtendo a data da consulta do resultado da consulta SQL
        $row = $result->fetch_assoc();
        $data_consulta = $row['data_consulta'];

        // Calculando a diferença de horas entre a data atual e a data da consulta
        $data_atual = new DateTime();
        $data_consulta = new DateTime($data_consulta);
        $diferenca_horas = $data_atual->diff($data_consulta)->h;

        // Verificar se a diferença é menor que 72 horas (ou seja, 3 dias)
        if ($diferenca_horas < 72) {
            echo "Você não pode editar esta consulta porque já se passaram menos de 72 horas desde a data da consulta.";
            // Encerrar o script ou redirecionar o usuário para uma página de erro
            exit;
        } else {
            // Permitir a edição da consulta
            // Seu código para processar a edição da consulta aqui
        }
    } else {
        echo "Consulta não encontrada.";
    }

    // Fechar a conexão com o banco de dados após o uso
    $conn->close();
}
?>

<?php

ini_set('display_errors', 0); // Não exibe erros na tela
ini_set('log_errors', 1);    // Ativa o log de erros
ini_set('error_log', '/path/to/php-error.log'); // Certifique-se de que o caminho é válido e gravável pelo servidor

require("opto/api/conexaoPDO.php");

// Obtém a conexão com o banco de dados
$pdo = getConexao();
$atualDate = date("Y-m-d H:i:s");

$recipient = "77981358888";
$message = "Teste de funcionamento";
$responseMessage = "Resposta automática gerada pelo sistema.";

try {
    // Inserir a pergunta na tabela question
    $sqlInsertQuestion = "INSERT INTO question (tel, message, timestamp) VALUES (:tel, :message, :timestamp)";
    $stmt = $pdo->prepare($sqlInsertQuestion);
    $stmt->bindParam(':tel', $recipient);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':timestamp', $atualDate);
    $stmt->execute();

    // Obter o ID da pergunta inserida
    $questionId = $pdo->lastInsertId();

    // Inserir a resposta na tabela response
    $sqlInsertResponse = "INSERT INTO response (question_id, response) VALUES (:question_id, :response)";
    $stmt = $pdo->prepare($sqlInsertResponse);
    $stmt->bindParam(':question_id', $questionId, PDO::PARAM_INT);
    $stmt->bindParam(':response', $responseMessage);
    $stmt->execute();

} catch (PDOException $e) {
    // Log de erro silencioso (opcional)
    error_log("Erro ao executar a consulta: " . $e->getMessage());
}

// Sem retorno ou saída
?>

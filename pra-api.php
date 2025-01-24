<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // URL da API FastAPI
    $apiUrl = "https://ha4xeiws18.execute-api.us-east-1.amazonaws.com/ask";

    // Obtem a pergunta enviada pelo formulário
    $question = $_POST["question"] ?? "";

    if (!empty($question)) {
        // Dados para a requisição POST
        $data = [
            "question" => $question
        ];

        // Token de autenticação
        $authToken = "b9q5ioj6Caz967VEux7ELr6huRYbMP3hZcETSeij9emxiOGX3exxcVFMi02EBujm"; // Defina o token conforme o seu código

        // Inicializa o cURL
        $curl = curl_init();

        // Configurações do cURL
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl, // URL da API
            CURLOPT_POST => true,   // Método POST
            CURLOPT_RETURNTRANSFER => true, // Retorna o resultado como string
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json", // Cabeçalho indicando JSON
                "token: " . $authToken // Passa o token como cabeçalho `token`
            ],
            CURLOPT_POSTFIELDS => json_encode($data) // Dados no corpo da requisição
        ]);

        // Executa a requisição
        $response = curl_exec($curl);

        // Verifica se houve erro na requisição
        if ($response === false) {
            $responseMessage = "Erro na requisição: " . curl_error($curl);
        } else {
            // Converte a resposta de JSON para array associativo
            $responseData = json_decode($response, true);

            // Processa a resposta
            if (isset($responseData['response'])) {
                $responseMessage = "Resposta da API: " . htmlspecialchars($responseData['response']);
            } else {
                $responseMessage = "Erro ao interpretar a resposta da API: " . htmlspecialchars($response);
            }
        }

        // Fecha a conexão cURL
        curl_close($curl);
    } else {
        $responseMessage = "Por favor, insira uma pergunta.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumir API - Pergunta</title>
</head>
<body>
    <h1>Faça uma pergunta à API</h1>
    <form method="POST">
        <label for="question">Digite sua pergunta:</label><br>
        <input type="text" id="question" name="question" style="width: 100%; padding: 8px; margin: 10px 0;" required>
        <button type="submit" style="padding: 8px 16px;">Enviar</button>
    </form>

    <?php if (!empty($responseMessage)): ?>
        <div style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;">
            <?php echo $responseMessage; ?>
        </div>
    <?php endif; ?>
</body>
</html>

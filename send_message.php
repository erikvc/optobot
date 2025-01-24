<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // URL da API FastAPI
    $apiUrl = "https://ha4xeiws18.execute-api.us-east-1.amazonaws.com/ask";

    // Dados recebidos do formulário
    $recipient = $_POST['recipient']; // Número do destinatário
    $message = $_POST['message']; // Mensagem a ser enviada
    $question = $_POST["question"] ?? ""; // Pergunta a ser enviada à API

    if (!empty($question)) {
        // Dados para a requisição POST para a API FastAPI
        $data = [
            "question" => $question
        ];

        // Token de autenticação da API FastAPI
        $authToken = "b9q5ioj6Caz967VEux7ELr6huRYbMP3hZcETSeij9emxiOGX3exxcVFMi02EBujm"; // Altere com seu token

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
                $responseMessage = htmlspecialchars($responseData['response']);
            } else {
                $responseMessage = "Erro ao interpretar a resposta da API: " . htmlspecialchars($response);
            }
        }

        // Fecha a conexão cURL
        curl_close($curl);


        //FEITO POR ERIK ALMEIDA
        require("opto/api/conexaoPDO.php");

        // Obtém a conexão com o banco de dados
        $pdo = getConexao();
        $atualDate = date("Y-m-d H:i:s");

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
        //FINAL FEITO POR ERIK ALMEIDA

    } else {
        $responseMessage = "Por favor, insira uma pergunta.";
    }

    // Salvar a mensagem, número e resposta no arquivo JSON
    $logFile = 'dialogues.json';
    $existingDialogs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];

    // Adiciona o novo diálogo
    $existingDialogs[] = [
        'from' => $recipient,
        'message' => $message,
        'response' => $responseMessage,
        'timestamp' => date("Y-m-d H:i:s")
    ];

    // Salva os dados no arquivo
    file_put_contents($logFile, json_encode($existingDialogs, JSON_PRETTY_PRINT));

    // Enviar a resposta ou erro para o WhatsApp
    $token = 'EAANOqcNAZAzMBO5SZA8FdtgPJ8eZCkhHZCfCbbHYhuOOh9H06w6rFVVWYONZBrAyw2wqggDjJtJOMWc53run4vCUKmyZCZBwY6PV8y6RbbMo6ZCucCFZC96GvDrfexRGyqSHWekfBk6cDUBL9o8amxGasX08lhtGk9dAhUAs8RqZAQ1AOyDbdLvb5gBNOzhexIvMlg7gZDZD';
    $phone_number_id = '534583086401789'; // ID do número de WhatsApp

    function sendMessageToWhatsApp($recipient, $message) {
        global $token, $phone_number_id;

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $recipient,
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];

        // Inicializa o cURL
        $ch = curl_init("https://graph.facebook.com/v17.0/$phone_number_id/messages");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Envia a requisição
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    // Enviar a resposta ou erro para o WhatsApp
    sendMessageToWhatsApp($recipient, $responseMessage);
}
?>

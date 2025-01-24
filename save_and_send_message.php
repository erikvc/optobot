<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configurações da API do WhatsApp
    $token = 'EAANOqcNAZAzMBO5SZA8FdtgPJ8eZCkhHZCfCbbHYhuOOh9H06w6rFVVWYONZBrAyw2wqggDjJtJOMWc53run4vCUKmyZCZBwY6PV8y6RbbMo6ZCucCFZC96GvDrfexRGyqSHWekfBk6cDUBL9o8amxGasX08lhtGk9dAhUAs8RqZAQ1AOyDbdLvb5gBNOzhexIvMlg7gZDZD';
    $phone_number_id = '534583086401789'; // ID do número de telefone no Meta Developers

    // Dados recebidos do formulário
    $recipient = $_POST['recipient']; // Número do destinatário
    $message = $_POST['message']; // Mensagem a ser enviada

    // URL da API do WhatsApp
    $url = "https://graph.facebook.com/v17.0/$phone_number_id/messages";

    // Dados da mensagem
    $data = [
        'messaging_product' => 'whatsapp',
        'to' => $recipient,
        'type' => 'text',
        'text' => [
            'body' => $message
        ]
    ];

    // Inicializa o CURL para envio da mensagem
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Envia a requisição
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Salvar a mensagem no arquivo response.json
    $responseData = [
        'to' => $recipient,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    $file = 'response.json';

    if (file_exists($file)) {
        $savedData = json_decode(file_get_contents($file), true);
    } else {
        $savedData = [];
    }

    $savedData[] = $responseData;

    // Tenta salvar a mensagem no arquivo
    $saveStatus = file_put_contents($file, json_encode($savedData, JSON_PRETTY_PRINT));

    // Retorna o status final como JSON
    header('Content-Type: application/json');
    if ($http_code == 200 && $saveStatus) {
        echo json_encode([
            'status' => 'success',
            'response' => 'Mensagem enviada e salva com sucesso!',
            'api_response' => $response
        ]);
    } else {
        $errorMessage = [];
        if ($http_code !== 200) {
            $errorMessage[] = 'Erro no envio da mensagem para a API.';
        }
        if (!$saveStatus) {
            $errorMessage[] = 'Erro ao salvar a mensagem no arquivo.';
        }
        echo json_encode([
            'status' => 'error',
            'errors' => $errorMessage,
            'http_code' => $http_code,
            'api_response' => $response
        ]);
    }
} else {
    // Caso o método não seja POST
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'response' => 'Método inválido.']);
}

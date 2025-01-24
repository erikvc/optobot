<?php
// Defina o token de verificação (deve ser o mesmo configurado no Meta Developers)
$verify_token = "SEU_TOKEN_DE_VERIFICACAO";

// 1. Verificação do Webhook
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $mode = $_GET['hub_mode'];
    $token = $_GET['hub_verify_token'];
    $challenge = $_GET['hub_challenge'];

    if ($mode === 'subscribe' && $token === $verify_token) {
        echo $challenge;
        http_response_code(200);
        exit;
    } else {
        http_response_code(403);
        exit;
    }
}

// 2. Processamento de mensagens recebidas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture os dados enviados pelo WhatsApp
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    // Verifique se há mensagens
    if (isset($data['entry'][0]['changes'][0]['value']['messages'])) {
        $messages = $data['entry'][0]['changes'][0]['value']['messages'];

        foreach ($messages as $message) {
            $from = $message['from']; // Número do remetente
            $text = $message['text']['body'] ?? ''; // Mensagem de texto

            // Agora, chamamos o arquivo `send_message.php` para processar a resposta
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://optocreative.com/proof/optobot/send_message.php");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'recipient' => $from,
                'message' => $text, // Mensagem do webhook
                'question' => $text // Enviando a mensagem como 'question'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }

    http_response_code(200);
    echo "EVENT_RECEIVED";
    exit;
}

http_response_code(404);
exit;
?>

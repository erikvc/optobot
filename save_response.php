<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient = $_POST['recipient'];
    $message = $_POST['message'];

    $responseData = [
        'to' => $recipient,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    $file = 'response.json';

    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
    } else {
        $data = [];
    }

    $data[] = $responseData;

    if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT))) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'response' => 'Erro ao salvar resposta.']);
    }
} else {
    echo json_encode(['status' => 'error', 'response' => 'Método inválido.']);
}

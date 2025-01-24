<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o ID do usuário enviado pela API
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;

    if ($user_id) {
        // Armazena o ID na sessão
        $_SESSION['optobot'] = $user_id;
        echo json_encode(['success' => true, 'message' => 'Sessão criada com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID do usuário não fornecido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido. Use POST.']);
}
?>

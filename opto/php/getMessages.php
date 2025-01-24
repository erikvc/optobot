<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../api/conexaoPDO.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $phoneNumber = $_GET['phone_number'] ?? null;

    if ($phoneNumber) {
        try {
            $pdo = getConexao();

            // Consulta para buscar mensagens do número especificado
            $stmt = $pdo->prepare("
                SELECT q.message AS user_message, q.timestamp AS user_timestamp,
                       r.response AS bot_response, r.id AS response_id
                FROM question q
                LEFT JOIN response r ON q.id = r.question_id
                WHERE q.tel = :phone_number
                ORDER BY q.timestamp DESC
            ");
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->execute();

            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'messages' => $messages]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Número de telefone não fornecido.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método inválido. Use GET.']);
}
?>

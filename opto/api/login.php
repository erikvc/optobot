<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'conexaoPDO.php'; // Inclui o arquivo de conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    // Verifica se os campos foram enviados
    if (empty($email) || empty($password)) {
        echo json_encode([
            'USER_ID' => null,
            'MSG' => 'Por favor, preencha todos os campos.'
        ]);
        exit;
    }

    try {
        $pdo = getConexao();

        // Consulta o banco de dados para encontrar o email
        $stmt = $pdo->prepare('SELECT id, senha FROM clientes WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica a senha usando password_verify
            if (password_verify($password, $user['senha'])) {
                echo json_encode([
                    'USER_ID' => $user['id'],
                    'MSG' => 'success'
                ]);
            } else {
                echo json_encode([
                    'USER_ID' => null,
                    'MSG' => 'Senha incorreta.'
                ]);
            }
        } else {
            echo json_encode([
                'USER_ID' => null,
                'MSG' => 'Usuário não encontrado.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'USER_ID' => null,
            'MSG' => 'Erro ao processar o login: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'USER_ID' => null,
        'MSG' => 'Método de requisição inválido. Use POST.'
    ]);
}
?>

<?php
require_once '../../opto/api/conexaoPDO.php';

$pdo = getConexao();

// Obtém o termo de pesquisa
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Consulta para buscar os números de telefone
$query = "
    SELECT tel, MAX(timestamp) AS timestamp
    FROM question
    WHERE tel LIKE :search
    GROUP BY tel
    ORDER BY MAX(timestamp) DESC
";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
$stmt->execute();

$phoneNumbers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna os dados em JSON
header('Content-Type: application/json');
echo json_encode($phoneNumbers);
?>

<?php
// Carregar os diálogos do arquivo JSON
if (file_exists('dialogues.json')) {
    $dialogues = json_decode(file_get_contents('dialogues.json'), true);
    
    // Ordena os diálogos por número de telefone
    usort($dialogues, function ($a, $b) {
        return strcmp($a['from'], $b['from']);
    });

    // Retorna os diálogos como JSON
    echo json_encode($dialogues);
} else {
    echo json_encode([]);
}
?>

<?php
// Conexão com o banco de dados usando PDO
function getConexao() {
    $host = 'localhost';
    $dbname = 'optocrea_optobot';
    $user = 'optocrea_opto1'; // Substitua pelo seu usuário
    $password = 'fAd]2M_86srO'; // Substitua pela sua senha

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    }
}
?>

<?php
try {
    $conexao = new PDO(
        'mysql:host=localhost;dbname=gestao_sorveteria;charset=utf8',
        'root',
        '',
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8')
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro na conexão:' . $e->getMessage() . '<br>';
    echo 'Código do erro:' . $e->getCode();
    exit;
}

// Ticket médio por mês
$sql = "SELECT d.data AS data_hora, d.temperatura AS var_temp
        FROM dados_iot d
        ORDER BY data_hora ASC";

$stmt = $conexao->query($sql);
$temperaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formatando para JSON
$labels = [];
$dados = [];

foreach ($temperaturas as $temperatura) {
    $labels[] = date('d/m H\h', strtotime($temperatura['data_hora']));
    $dados[] = $temperatura['var_temp'];
}

echo json_encode(['labels' => $labels, 'dados' => $dados]);
?>
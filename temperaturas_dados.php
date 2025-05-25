<?php
include 'conexao.php';

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
<?php
include 'conexao.php';

$sql = "SELECT d.data AS data_hora, d.consumo_total AS consumo
        FROM dados_iot d
        ORDER BY data_hora ASC";

$stmt = $conexao->query($sql);
$consumo_total = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formatando para JSON
$labels = [];
$dados = [];

foreach ($consumo_total as $consumo) {
    $labels[] = date('d/m H\h', strtotime($consumo['data_hora']));
    $dados[] = $consumo['consumo'];
}

echo json_encode(['labels' => $labels, 'dados' => $dados]);
?>
<?php
include 'conexao.php';

$sql = "SELECT d.data AS data_hora, d.umidade AS var_umi
        FROM dados_iot d
        ORDER BY data_hora ASC";

$stmt = $conexao->query($sql);
$dados_umidade = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formatando para JSON
$labels = [];
$dados = [];

foreach ($dados_umidade as $umidade) {
    $labels[] = date('d/m H\h', strtotime($umidade['data_hora']));
    $dados[] = $umidade['var_umi'];
}

echo json_encode(['labels' => $labels, 'dados' => $dados]);
?>
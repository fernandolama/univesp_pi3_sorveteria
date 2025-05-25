<?php
include 'conexao.php';

// Total de vendas por mês
$sql = "SELECT DATE_FORMAT(v.data, '%Y-%m') AS mes, SUM(v.quantidade) AS total_vendas
        FROM vendas v
        GROUP BY mes
        ORDER BY mes ASC";

$stmt = $conexao->query($sql); // Usando $conexao em vez de $pdo
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formatando para JSON
$labels = [];
$dados = [];

foreach ($vendas as $venda) {
    $labels[] = $venda['mes'];
    $dados[] = $venda['total_vendas'];
}

echo json_encode(['labels' => $labels, 'dados' => $dados]);
?>
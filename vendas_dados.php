<?php
$pdo = new PDO("mysql:host=localhost;dbname=gestao_sorveteria", "root", "");

// Total de vendas por mês
$sql = "SELECT DATE_FORMAT(p.data_pedido, '%Y-%m') AS mes, SUM(ip.quantidade) AS total_vendas
        FROM pedidos p
        JOIN itens_pedido ip ON p.id_pedido = ip.id_pedido
        GROUP BY mes
        ORDER BY mes ASC";

$stmt = $pdo->query($sql);
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

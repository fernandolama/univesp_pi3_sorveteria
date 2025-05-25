<?php
include 'conexao.php';

// Ticket médio por mês
$sql = "SELECT DATE_FORMAT(v.data, '%Y-%m') AS mes,
        SUM(v.quantidade * v.valor) / COUNT(DISTINCT v.id_venda) AS ticket_medio
        FROM vendas v
        GROUP BY mes
        ORDER BY mes ASC";

$stmt = $conexao->query($sql);
$tmedios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formatando para JSON
$labels = [];
$dados = [];

foreach ($tmedios as $tmedio) {
    $labels[] = $tmedio['mes'];
    $dados[] = round($tmedio['ticket_medio'], 2); // Arredonda para 2 casas decimais
}

echo json_encode(['labels' => $labels, 'dados' => $dados]);
?>
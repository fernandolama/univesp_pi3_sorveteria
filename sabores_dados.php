<?php
$pdo = new PDO("mysql:host=localhost;dbname=gestao_sorveteria", "root", "");

// Consulta para obter os sabores mais vendidos
$sql = "SELECT p.nome AS sabor, SUM(ip.quantidade) AS total_vendido
        FROM itens_pedido ip
        JOIN produtos p ON ip.id_produto = p.id
        GROUP BY p.nome
        ORDER BY total_vendido DESC
        LIMIT 10";

$stmt = $pdo->query($sql);
$sabores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formatando para JSON
$labels = [];
$dados = [];

foreach ($sabores as $sabor) {
    $labels[] = $sabor['sabor'];
    $dados[] = $sabor['total_vendido'];
}

echo json_encode(['labels' => $labels, 'dados' => $dados]);
?>

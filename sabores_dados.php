<?php
include 'conexao.php';

// Consulta para obter os sabores mais vendidos
$sql = "SELECT p.produto AS sabor, SUM(v.quantidade) AS total_vendido
        FROM vendas v
        JOIN produtos p ON v.id_produto = p.id
        GROUP BY p.produto
        ORDER BY total_vendido DESC
        LIMIT 10";

$stmt = $conexao->query($sql); // Utilizando a variável $conexao definida em conexao.php
$sabores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formatando os dados para JSON
$labels = [];
$dados = [];

foreach ($sabores as $sabor) {
    $labels[] = $sabor['sabor'];
    $dados[] = $sabor['total_vendido'];
}

echo json_encode(['labels' => $labels, 'dados' => $dados]);
?>


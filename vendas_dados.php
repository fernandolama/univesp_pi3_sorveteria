<?php
try {
    $conexao = new PDO(
        'mysql:host=localhost;dbname=softdesignercom_sorveteria;charset=utf8',
        'softdesignercom_engenheiro',
        'Sedex@2025',
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8')
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro na conexão:' . $e->getMessage() . '<br>';
    echo 'Código do erro:' . $e->getCode();
    exit;
}

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
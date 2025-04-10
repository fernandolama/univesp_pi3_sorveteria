<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "gestao_sorveteria");

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

$query = "
    SELECT DATE_FORMAT(p.data_pedido, '%Y-%m') AS mes, 
           SUM(i.quantidade * i.preco_unitario) / COUNT(DISTINCT p.id_pedido) AS ticket_medio
    FROM pedidos p
    JOIN itens_pedido i ON p.id_pedido = i.id_pedido
    GROUP BY mes
    ORDER BY mes;
";

$result = $mysqli->query($query);
$labels = [];
$dados = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['mes'];
    $dados[] = round($row['ticket_medio'], 2); // Arredonda para 2 casas decimais
}

echo json_encode(["labels" => $labels, "dados" => $dados]);

$mysqli->close();
?>

<?php
include 'conexao.php';

try {
    // Consulta os dados mais recentes da previsão do tempo no banco de dados local
    $stmt = $conexao->prepare("SELECT temperatura, umidade, chuva FROM previsao_tempo ORDER BY data DESC LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se há dados retornados
    if ($resultado) {
        // Converte os dados para JSON
        $json_data = json_encode($resultado, JSON_PRETTY_PRINT);

        // Escreve os dados no arquivo JSON
        file_put_contents('dados_tempo.json', $json_data);

        // Retorna os dados JSON para a requisição
        echo $json_data;
    } else {
        echo json_encode(['error' => 'Nenhum dado encontrado']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
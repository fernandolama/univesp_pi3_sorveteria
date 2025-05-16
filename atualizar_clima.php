<?php
include 'conexao.php';

function atualizarClima() {
    global $conexao;
    $conexao->exec("USE gestao_sorveteria");
    $apiKey = "6ca46efd4709d5194b24a78247d4e547";
    $url = "https://api.openweathermap.org/data/2.5/weather?q=Itamogi,BR&appid=$apiKey&units=metric&lang=pt";
    $json = file_get_contents($url);

    if (!$json) {
        echo "Erro ao acessar a API.";
        return;
    }

    $data = json_decode($json, true);
    $dataRegistro = date('Y-m-d H:i:s'); // Timestamp atual
    $temperatura = $data['main']['temp'] ?? null;
    $umidade = $data['main']['humidity'] ?? null;
    $chuva = isset($data['rain']['1h']) ? 'Sim' : 'Não'; // Verifica se houve chuva na última hora

    // Inserção no banco de dados
    $sql = "INSERT INTO previsao_tempo (data, temperatura, umidade, chuva)
            VALUES (:data, :temperatura, :umidade, :chuva)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':data', $dataRegistro);
    $stmt->bindParam(':temperatura', $temperatura);
    $stmt->bindParam(':umidade', $umidade);
    $stmt->bindParam(':chuva', $chuva);

    if ($stmt->execute()) {
        echo "Dados meteorológicos de Itamogi atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar os dados.";
    }
}

atualizarClima();
?>
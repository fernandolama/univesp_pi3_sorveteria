<?php
include 'conexao.php';

function obterUltimoRegistro() {
    global $conexao;
    $stmt = $conexao->query("SELECT * FROM previsao_tempo ORDER BY data DESC LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function atualizarClima() {
    global $conexao;
    $apiKey = "6ca46efd4709d5194b24a78247d4e547"; 
    $url = "https://api.openweathermap.org/data/2.5/weather?q=Itamogi,BR&appid=$apiKey&units=metric&lang=pt";
    $json = file_get_contents($url);

    if (!$json) {
        echo "Erro ao acessar a API.";
        return null;
    }

    $data = json_decode($json, true);

    $dataRegistro = date('Y-m-d H:i:s');
    $temperatura = $data['main']['temp'] ?? null;
    $umidade = $data['main']['humidity'] ?? null;
    $chuva = isset($data['rain']['1h']) ? 'Sim' : 'Não';

    // Pega as coordenadas para uso no mapa
    $latitude = $data['coord']['lat'] ?? -21.0764;
    $longitude = $data['coord']['lon'] ?? -47.0497;

    // Salva apenas os dados meteorológicos
    $sql = "INSERT INTO previsao_tempo (data, temperatura, umidade, chuva)
            VALUES (:data, :temperatura, :umidade, :chuva)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':data', $dataRegistro);
    $stmt->bindParam(':temperatura', $temperatura);
    $stmt->bindParam(':umidade', $umidade);
    $stmt->bindParam(':chuva', $chuva);
    $stmt->execute();

    return [
        'data' => $dataRegistro,
        'temperatura' => $temperatura,
        'umidade' => $umidade,
        'chuva' => $chuva,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];
}

// Verifica se precisa atualizar
$registro = obterUltimoRegistro();
$agora = time();

if (!$registro || (strtotime($registro['data']) + 3600 < $agora)) {
    $dados = atualizarClima();
    $origem = "Dados atualizados da API.";
} else {
    $dados = $registro;
    $origem = "Dados do banco (menos de 60 minutos).";
    $dados['latitude'] = -21.0764;
    $dados['longitude'] = -47.0497;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Previsão do Tempo - Itamogi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        iframe { margin-top: 15px; border: none; width: 100%; height: 400px; }
    </style>
</head>
<body>
    <h2>Previsão do Tempo - Itamogi</h2>
    <p><strong>Fonte:</strong> <?= $origem ?></p>
    <p><strong>Data:</strong> <?= $dados['data'] ?></p>
    <p><strong>Temperatura:</strong> <?= $dados['temperatura'] ?>°C</p>
    <p><strong>Umidade:</strong> <?= $dados['umidade'] ?>%</p>
    <p><strong>Chuva:</strong> <?= $dados['chuva'] ?></p>
    <p><strong>Coordenadas:</strong> Latitude <?= $dados['latitude'] ?>, Longitude <?= $dados['longitude'] ?></p>
    <iframe src="mapa.php?lat=<?= $dados['latitude'] ?>&lon=<?= $dados['longitude'] ?>"></iframe>
</body>
</html>

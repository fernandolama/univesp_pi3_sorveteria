<?php
include 'conexao.php';
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;

function atualizarBanco() {
    global $conexao;

    $credencialJson = 'C:/xampp/htdocs/gestao_sorveteria/chave.json';
    $client = new Client();
    $client->setAuthConfig($credencialJson);
    $client->addScope(Sheets::SPREADSHEETS_READONLY);

    $service = new Sheets($client);
    $spreadsheetId = '1pjZyhjTbZe5txrxyuaitfTHG06qMmeEyYKQfqhFWH4M';
    $range = 'Página1';
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    if (empty($values)) {
        return "Nenhum dado encontrado na planilha.";
    }

    // Pega a última data inserida no banco
    $stmt = $conexao->prepare("SELECT MAX(data) FROM dados_iot");
    $stmt->execute();
    $ultimaData = $stmt->fetchColumn();

    // Prepara SQL de inserção
    $sql = "INSERT INTO dados_iot (data, corrente_fase1, corrente_fase2, tensao_fase1, tensao_fase2, consumo_total, temperatura, umidade)
            VALUES (:data, :corrente_fase1, :corrente_fase2, :tensao_fase1, :tensao_fase2, :consumo_total, :temperatura, :umidade)";
    $stmtInsert = $conexao->prepare($sql);

    $contador = 0;

    foreach ($values as $index => $row) {
        if ($index === 0) continue; // Pula cabeçalho

        $dataPlanilha = isset($row[0]) ? date('Y-m-d H:i:s', strtotime($row[0])) : null;

        // Só insere se a data for mais recente
        if ($ultimaData && $dataPlanilha <= $ultimaData) {
            continue;
        }

        $dados = [
            ':data'             => $dataPlanilha,
            ':corrente_fase1'   => isset($row[1]) ? (float)$row[1] : null,
            ':corrente_fase2'   => isset($row[2]) ? (float)$row[2] : null,
            ':tensao_fase1'     => isset($row[3]) ? (float)$row[3] : null,
            ':tensao_fase2'     => isset($row[4]) ? (float)$row[4] : null,
            ':consumo_total'    => isset($row[5]) ? (float)$row[5] : null,
            ':temperatura'      => isset($row[6]) ? (float)$row[6] : null,
            ':umidade'          => isset($row[7]) ? (float)$row[7] : null
        ];

        try {
            $stmtInsert->execute($dados);
            $contador++;
        } catch (PDOException $e) {
            return "Erro ao inserir dados: " . $e->getMessage();
        }
    }

    if ($contador === 0) {
        return "Nenhum novo dado para inserir.";
    }

    return "Foram inseridos $contador novos registros.";
}

// Se for chamado via AJAX
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    $msg = atualizarBanco();
    header('Content-Type: application/json');
    echo json_encode(['message' => $msg]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atualização de Dados IoT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        h1 {
            text-align: center;
        }
        p {
            text-align: center;
        }
        .update-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #0077cc;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .update-link:hover {
            background-color: #005fa3;
        }
        .status {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #e0e0e0;
            text-align: center;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #555;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .back-link:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Atualização de Dados IoT</h1>
        <p>
            Os dados do banco serão atualizados automaticamente a cada 15 minutos.
            Para atualizar manualmente, clique no botão abaixo.
        </p>
        <p>
            <a href="#" id="atualizarLink" class="update-link">Atualizar Agora</a>
        </p>
        <div id="statusMessage" class="status" aria-live="polite">Aguardando ação do usuário...</div>
        <p>
            <a href="adm.php" class="back-link">Voltar</a>
        </p>
    </div>

    <script>
        function atualizarDados() {
            document.getElementById('statusMessage').textContent = "Atualizando dados...";
            fetch('?ajax=1')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('statusMessage').textContent = data.message;
                })
                .catch(error => {
                    document.getElementById('statusMessage').textContent = 'Erro na atualização: ' + error;
                });
        }

        setInterval(atualizarDados, 900000); // 15 minutos
        document.getElementById('atualizarLink').addEventListener('click', function(event) {
            event.preventDefault();
            atualizarDados();
        });
    </script>
</body>
</html>

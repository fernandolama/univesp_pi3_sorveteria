<?php
include 'conexao.php';
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;

function atualizarBanco() {
    global $conexao;

    // Configurações do cliente Google
    $credencialJson = 'C:/xampp/htdocs/gestao_sorveteria/chave.json';
    $client = new Client();
    $client->setAuthConfig($credencialJson);
    $client->addScope(Sheets::SPREADSHEETS_READONLY);

    // Serviço Google Sheets
    $service = new Sheets($client);
    $spreadsheetId = '1pjZyhjTbZe5txrxyuaitfTHG06qMmeEyYKQfqhFWH4M';
    $range = 'Página1';
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    if (empty($values)) {
        return "Nenhum dado encontrado na planilha.";
    }

    // Obter número de registros no banco
    $sql_check = "SELECT COUNT(*) FROM dados_iot";
    $stmt_check = $conexao->prepare($sql_check);
    $stmt_check->execute();
    $row_count_db = $stmt_check->fetchColumn();
    // Desconsidera a linha de cabeçalho
    $row_count_sheet = count($values) - 1;

    if ($row_count_db >= $row_count_sheet) {
        return "Nenhum novo dado para atualizar.";
    }

    // Inserir dados no banco
    $sql = "INSERT INTO dados_iot (data, corrente_fase1, corrente_fase2, tensao_fase1, tensao_fase2, consumo_total, temperatura, umidade)
            VALUES (:data, :corrente_fase1, :corrente_fase2, :tensao_fase1, :tensao_fase2, :consumo_total, :temperatura, :umidade)";
    $stmt = $conexao->prepare($sql);

    for ($i = $row_count_db; $i < $row_count_sheet; $i++) {
        $row = $values[$i + 1]; // pula a linha de cabeçalho

        // Prepara os dados com tratamento e conversão apropriada
        $dados = [
            ':data'             => isset($row[0]) ? date('Y-m-d H:i:s', strtotime($row[0])) : null,
            ':corrente_fase1'   => isset($row[1]) ? (float)$row[1] : null,
            ':corrente_fase2'   => isset($row[2]) ? (float)$row[2] : null,
            ':tensao_fase1'     => isset($row[3]) ? (float)$row[3] : null,
            ':tensao_fase2'     => isset($row[4]) ? (float)$row[4] : null,
            ':consumo_total'    => isset($row[5]) ? (float)$row[5] : null,
            ':temperatura'      => isset($row[6]) ? (float)$row[6] : null,
            ':umidade'          => isset($row[7]) ? (float)$row[7] : null
        ];

        try {
            $stmt->execute($dados);
        } catch (PDOException $e) {
            return "Erro ao inserir dados: " . $e->getMessage();
        }
    }

    return "Atualização realizada com sucesso.";
}

// Se for chamado via AJAX (parâmetro ajax=1), executa a atualização e retorna o resultado em JSON.
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
        /* Estilos internos seguindo boas práticas W3C */
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
        .update-link:hover,
        .update-link:focus {
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
        .back-link:hover,
        .back-link:focus {
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
        <!-- Botão para atualização manual -->
        <p>
            <a href="#" id="atualizarLink" class="update-link">Atualizar Agora</a>
        </p>
        <!-- Área para exibição das mensagens de status -->
        <div id="statusMessage" class="status" aria-live="polite"></div>
        <!-- Botão para voltar à página de administração -->
        <p>
            <a href="adm.php" class="back-link">Voltar</a>
        </p>
    </div>
    
    <script>
        // Função que realiza a chamada AJAX para atualizar os dados
        function atualizarDados() {
            fetch('?ajax=1')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('statusMessage').textContent = data.message;
                })
                .catch(error => {
                    document.getElementById('statusMessage').textContent = 'Erro na atualização: ' + error;
                });
        }

        // Atualização automática a cada 15 minutos (900000 milissegundos)
        setInterval(atualizarDados, 900000);

        // Atualização manual ao clicar no botão, sem recarregar a página
        document.getElementById('atualizarLink').addEventListener('click', function(event) {
            event.preventDefault();
            atualizarDados();
        });
    </script>
</body>
</html>
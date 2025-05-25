<?php

include 'conexao.php';

// Add o Composer usar a API do Google carrega o composer
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;

// Função para atualizar os dados no banco de dados
function atualizarBanco() {
    global $conexao;
    $conexao->exec("USE gestao_sorveteria");
    $credencialJson = 'C:/xampp/htdocs/gestao_sorveteria/chave.json';  // Substituir para onde for salvo a chave JSON
    $client = new Client();
    $client->setAuthConfig($credencialJson);
    $client->addScope(Sheets::SPREADSHEETS_READONLY);
    $service = new Sheets($client);
    $spreadsheetId = '1pjZyhjTbZe5txrxyuaitfTHG06qMmeEyYKQfqhFWH4M';
    $range = 'Página1';
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    if (empty($values)) {
        echo "Nenhum dado encontrado na planilha.";
        return;
    }

    $sql_check = "SELECT COUNT(*) FROM dados_iot";// vê o número total de registros no bd
    $stmt_check = $conexao->prepare($sql_check);
    $stmt_check->execute();
    $row_count_db = $stmt_check->fetchColumn();

    $row_count_sheet = count($values) - 1;

    if ($row_count_db >= $row_count_sheet) {
        echo "Todos os dados já foram atualizados no banco.";
        return;
    }
    // Preparar a consulta SQL para inserir os dados
    $sql = "INSERT INTO dados_iot (data, corrente_fase1, corrente_fase2, tensao_fase1, tensao_fase2, consumo_total, temperatura, umidade)
            VALUES (:data, :corrente_fase1, :corrente_fase2, :tensao_fase1, :tensao_fase2, :consumo_total, :temperatura, :umidade)";

    $stmt = $conexao->prepare($sql);

   for ($i = $row_count_db; $i < $row_count_sheet; $i++) {
        $row = $values[$i + 1];  // Pula a primeira linha (cabeçalho)
        $data_criacao = isset($row[0]) ? date('Y-m-d H:i:s', strtotime($row[0])) : null;
        $corrente_fase1 = isset($row[1]) ? (string)$row[1] : null;
        $corrente_fase2 = isset($row[2]) ? (string)$row[2] : null;
        $tensao_fase1 = isset($row[3]) ? (string)$row[3] : null;
        $tensao_fase2 = isset($row[4]) ? (string)$row[4] : null;
        $consumo_total = isset($row[5]) ? (string)$row[5] : null;
        $temperatura = isset($row[6]) ? (string)$row[6] : null;
        $umidade = isset($row[7]) ? (string)$row[7] : null;


        // Bind dos parâmetros para a execução da query
        $stmt->bindParam(':data', $data_criacao);
        $stmt->bindParam(':corrente_fase1', $corrente_fase1);
        $stmt->bindParam(':corrente_fase2', $corrente_fase2);
        $stmt->bindParam(':tensao_fase1', $tensao_fase1);
        $stmt->bindParam(':tensao_fase2', $tensao_fase2);
        $stmt->bindParam(':consumo_total', $consumo_total);
        $stmt->bindParam(':temperatura', $temperatura);
        $stmt->bindParam(':umidade', $umidade);

        // Executar a query
        $stmt->execute();
    }


    echo "Dados atualizados no banco com sucesso!";
}


atualizarBanco();

?>

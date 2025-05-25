<?php
include 'conexao.php';

// Define o número de registros por página
$limit = 50;

// Recupera o offset via parâmetro GET; se não existir, inicia em 0
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Prepara e executa a consulta com os parâmetros de LIMIT e OFFSET
$consulta = $conexao->prepare("SELECT * FROM dados_iot ORDER BY data DESC LIMIT :limit OFFSET :offset");
$consulta->bindValue(':limit', $limit, PDO::PARAM_INT);
$consulta->bindValue(':offset', $offset, PDO::PARAM_INT);
$consulta->execute();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dados IoT</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Estilo base e layout responsivo */
        body {
            background-color: #f1f1f1;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            background: #fff;
            margin: 0 auto 20px auto;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #0077cc;
            color: #fff;
            text-align: left;
            padding: 12px;
        }

        tbody td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        /* Linhas intercaladas para melhor leitura */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Destaque da linha ao passar o mouse */
        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .pagination {
            text-align: right;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            background-color: #0077cc;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .pagination a:hover {
            background-color: #005fa3;
        }

        /* Botão voltar para adm.php */
        .back-button {
            display: inline-block;
            background-color: #555;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
            margin-top: 20px;
            text-align: center;
        }

        .back-button:hover,
        .back-button:focus {
            background-color: #333;
        }
    </style>
</head>
<body>
<div style="width: 100%; height: 300px;">
<?php
	session_start();

    if (empty($_SESSION['adm']) || $_SESSION['adm']!=1){

      header('location:index.php'); 
    }
	
	include 'conexao.php';	
	include 'nav.php';
	include 'cabecalho.html';
	
	?>
    </div>
    <div class="container">
        <h2>Monitoramento IoT</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Corrente Fase 1</th>
                    <th>Corrente Fase 2</th>
                    <th>Tensão Fase 1</th>
                    <th>Tensão Fase 2</th>
                    <th>Consumo Total</th>
                    <th>Temperatura</th>
                    <th>Umidade</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($dados = $consulta->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($dados['data']); ?></td>
                    <td><?php echo htmlspecialchars($dados['corrente_fase1']); ?> A</td>
                    <td><?php echo htmlspecialchars($dados['corrente_fase2']); ?> A</td>
                    <td><?php echo htmlspecialchars($dados['tensao_fase1']); ?> V</td>
                    <td><?php echo htmlspecialchars($dados['tensao_fase2']); ?> V</td>
                    <td><?php echo htmlspecialchars($dados['consumo_total']); ?> kWh</td>
                    <td><?php echo htmlspecialchars($dados['temperatura']); ?> °C</td>
                    <td><?php echo htmlspecialchars($dados['umidade']); ?> %</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
                // Calcula o próximo offset e exibe o link para carregar mais 50 registros
                $nextOffset = $offset + $limit;
                echo '<a href="?offset=' . $nextOffset . '">Mostrar mais 50 registros</a>';
            ?>
        </div>
        
        <!-- Botão para voltar à página adm.php -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="adm.php" class="back-button">Voltar</a>
        </div>
    </div>
    
    <!-- Inclusão do rodapé -->
    <div>
        <?php include 'rodape.html'; ?>
    </div>
</body>
</html>
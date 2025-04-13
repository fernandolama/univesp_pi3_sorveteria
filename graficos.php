<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos e Métricas - Sorveteria Maranata</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0; /* Removendo bordas padrão para consistência */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f2f2f2; /* Fundo cinza claro */
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .grafico-container {
            background-color: #fff; /* Fundo branco dos gráficos */
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombra para destacar o elemento */
            padding: 20px;
            margin-bottom: 20px;
            width: 100%; /* Largura relativa */
            max-width: 900px; /* Limite de largura */
            text-align: center;
        }

        canvas {
            display: block;
            margin: 0 auto;
        }

        .botao-voltar {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .botao-voltar:hover {
            background-color: #555;
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
    <div class="grafico-container">
        <h2>Vendas por mês</h2>
        <div style="width: 100%; height: 300px;">
            <canvas id="graficoVendas"></canvas>
        </div>
    </div>

    <script>
        fetch('vendas_dados.php')
        .then(response => response.json())
        .then(data => {
            const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
                        "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

            const labelsFormatados = data.labels.map(label => {
                let partes = label.split('-');
                let mesIndex = parseInt(partes[1], 10) - 1;
                return meses[mesIndex] ?? label;
            });

            const ctx = document.getElementById('graficoVendas').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelsFormatados,
                    datasets: [{
                        label: 'Vendas por Mês',
                        data: data.dados.map(Number),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: true,
                                maxRotation: 45,
                                minRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

    <div class="grafico-container">
        <h2>Sabores Mais Vendidos</h2>
        <div style="width: 100%; height: 100%;">
            <canvas id="graficoSabores"></canvas>
        </div>
    </div>

    <script>
        fetch('sabores_dados.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('graficoSabores').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Vendas por Sabor',
                        data: data.dados,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(233, 30, 99, 0.5)',
                            'rgba(0, 150, 136, 0.5)',
                            'rgba(255, 193, 7, 0.5)',
                            'rgba(96, 125, 139, 0.5)'
                        ],
                        borderColor: 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        });
    </script>

    <!-- Botão de voltar para adm.php -->
    <a href="adm.php" class="botao-voltar">Voltar</a>

    <!-- Importando rodapé -->
    <div style="width: 100%; height: 300px;">
        <?php include 'rodape.html'; ?>
    </div>
</body>
</html>
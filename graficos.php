<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos e Métricas - Sorveteria Maranata</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Vendas por mês</h2>
    <div style="width: 400px; height: 300px;">
        <canvas id="graficoVendas"></canvas>
    </div>

    <script>
        fetch('vendas_dados.php')
        .then(response => response.json())
        .then(data => {
            // Lista de meses para conversão
            const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", 
                        "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

            // Converte "YYYY-MM" para "Mês"
            const labelsFormatados = data.labels.map(label => {
                let partes = label.split('-'); // Exemplo: "2024-03" -> ["2024", "03"]
                let mesIndex = parseInt(partes[1], 10) - 1; // Ajusta índice do mês (0-based)
                return meses[mesIndex] ?? label; // Retorna o nome do mês
            });

            console.log("Labels formatados:", labelsFormatados);
            console.log("Dados:", data.dados);

            const ctx = document.getElementById('graficoVendas').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelsFormatados, // Meses formatados
                    datasets: [{
                        label: 'Vendas por Mês',
                        data: data.dados.map(Number), // Garante que os dados sejam numéricos
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
                                autoSkip: false,
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

    <h2>Ticket Médio por mês</h2>
    <div style="width: 400px; height: 300px;">
        <canvas id="graficoTicketMedio"></canvas>
    </div>

    <script>
    fetch('ticketmedio_dados.php')
    .then(response => response.json())
    .then(data => {
        const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", 
                    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        const labelsFormatados = data.labels.map(label => {
            let partes = label.split('-');
            let mesIndex = parseInt(partes[1], 10) - 1;
            return meses[mesIndex] ?? label;
        });

        const ctx = document.getElementById('graficoTicketMedio').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsFormatados,
                datasets: [{
                    label: 'Ticket Médio (R$)',
                    data: data.dados.map(Number),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3 // Suaviza a curva do gráfico
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'R$'
                        }
                    }
                }
            }
        });
    });
    </script>


    <h2>Sabores mais vendidos</h2>
    <div style="width: 400px; height: 300px;">
        <canvas id="graficoSabores"></canvas>
    </div>

    <script>
        fetch('sabores_dados.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('graficoSabores').getContext('2d');
            new Chart(ctx, {
                type: 'pie', // Gráfico de pizza
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
</body>
</html>

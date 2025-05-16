<!DOCTYPE html>
<html>
<head>
    <title>Apresentação do Tempo - Sorveteria Maranata</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        #weather-info {
            font-size: 18px;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            display: inline-block;
            margin-bottom: 20px;
        }
        #map {
            height: 600px;
            width: 80%;
            margin: auto;
            border: 2px solid #ddd;
        }
        #update-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        #update-button:hover {
            background-color: #218838;
        }
        #update-message {
            margin-top: 10px;
            font-size: 16px;
            color: #007bff;
        }
    </style>
</head>
<body>

    <h2>Previsão do Tempo - Sorveteria Maranata</h2>
    <div id="weather-info">Carregando previsão do tempo...</div>

    <button id="update-button">Atualizar Dados do Clima</button>
    <div id="update-message"></div>

    <h3>Localização da Sorveteria Maranata</h3>
    <div id="map"></div>

    <!-- Biblioteca Leaflet.js -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Inicializa o mapa centrado na Sorveteria Maranata
        const map = L.map('map').setView([-21.0775185, -47.0515462], 17);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Adiciona marcador da Sorveteria Maranata
        L.marker([-21.0775185, -47.0515462]).addTo(map)
            .bindPopup('<b>Sorveteria Maranata</b><br>Itamogi, MG')
            .openPopup();

        // Obtém dados de previsão do tempo do banco de dados local
        function carregarDadosTempo() {
            fetch('dados_tempo.php')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('weather-info').innerHTML = `<p>Erro ao carregar dados: ${data.error}</p>`;
                    } else {
                        let info = `<h4>Previsão do Tempo</h4>
                                    <p><strong>Temperatura:</strong> ${data.temperatura}°C</p>
                                    <p><strong>Umidade:</strong> ${data.umidade}%</p>
                                    <p><strong>Chuva:</strong> ${data.chuva}</p>`;
                        document.getElementById('weather-info').innerHTML = info;
                    }
                })
                .catch(error => {
                    document.getElementById('weather-info').innerHTML = `<p>Erro ao carregar previsão do tempo.</p>`;
                    console.error('Erro ao carregar previsão do tempo:', error);
                });
        }

        // Atualiza os dados do clima ao clicar no botão
        document.getElementById('update-button').addEventListener('click', function() {
            fetch('atualizar_clima.php')
                .then(response => response.text())
                .then(message => {
                    document.getElementById('update-message').innerHTML = message;
                    carregarDadosTempo(); // Atualiza os dados na tela
                })
                .catch(error => {
                    document.getElementById('update-message').innerHTML = "Erro ao atualizar os dados.";
                    console.error('Erro ao atualizar o clima:', error);
                });
        });

        // Carrega os dados ao iniciar a página
        carregarDadosTempo();
    </script>

</body>
</html>
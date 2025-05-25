<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulário de Contato</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .whatsapp-btn {
            margin-top: 20px;
            text-align: center;
        }
        .whatsapp-btn a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            background-color: #25d366;
            color: white;
            text-decoration: none;
        }
        .whatsapp-btn a:hover {
            background-color: #1da851;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Formulário de Contato</h2>
        <form method="post" action="processarContato.php">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu email" required>
            </div>
            <div class="form-group">
                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" rows="5" class="form-control" placeholder="Digite sua mensagem" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
        </form>

        <!-- Botão de WhatsApp -->
        <div class="whatsapp-btn">
            <a href="https://wa.me/5535920008127?text=Olá! Gostaria de mais informações." target="_blank" aria-label="Contato via WhatsApp">
                <i class="fa fa-whatsapp"></i> Entrar em contato via WhatsApp
            </a>
        </div>
    </div>
</body>
</html>
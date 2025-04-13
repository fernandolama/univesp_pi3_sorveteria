<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sorveteria Maranata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- jQuery and Bootstrap JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        .navbar {
            margin-bottom: 0;
        }
        .produto {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }
        .produto img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .produto h1 {
            font-size: 18px;
            margin: 10px 0;
        }
        .produto h4 {
            font-size: 16px;
            color: #d9534f;
        }
        .btn {
            width: 100%;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php
        include 'conexao.php';
        include 'nav.php';
        include 'cabecalho.html';
        $consulta = $conexao->query('SELECT * FROM produtos');
    ?>

    <div class="container">
        <div class="row">
            <?php while ($exibir = $consulta->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="col-sm-3">
                    <div class="produto">
                        <img src="upload/<?php echo htmlspecialchars($exibir['foto1'] ?? 'default.jpg'); ?>" class="img-responsive" alt="Imagem do produto">
                        <h1><?php echo mb_strimwidth($exibir['produto'] ?? 'Produto sem nome', 0, 22, '...'); ?></h1>
                        <h4>R$ <?php echo number_format($exibir['preco'] ?? 0, 2, ',', '.'); ?></h4>
                        
                        <div class="text-center">
                            <a href="detalhes.php?id=<?php echo $exibir['id'] ?? '#'; ?>">
                                <button class="btn btn-info">
                                    <span class="glyphicon glyphicon-info-sign"></span> Detalhes
                                </button>
                            </a>
                        </div>
                        
                        <div class="text-center">
                            <?php if (($exibir['quantidade'] ?? 0) > 0) { ?>
                                <a href="carrinho.php?id=<?php echo $exibir['id'] ?? '#'; ?>">
                                    <button class="btn btn-success">
                                        <span class="glyphicon glyphicon-usd"></span> Comprar
                                    </button>
                                </a>
                            <?php } else { ?>
                                <button class="btn btn-danger" disabled>
                                    <span class="glyphicon glyphicon-ban-circle"></span> Indisponível
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include 'rodape.html'; ?>

</body>
</html>
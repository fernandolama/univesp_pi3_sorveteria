<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .produto {
            border-bottom: 1px solid #ccc;
            padding: 10px;
        }
        .produto img {
            max-width: 150px;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php
        include 'conexao.php';

        $consulta = $conexao->query('SELECT * FROM produtos');

        while ($exibe = $consulta->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="produto">';
            
            echo '<strong>Nome:</strong> ' . ($exibe['nome'] ?? 'Nome não disponível') . '<br>';
            echo '<strong>Descrição:</strong> ' . ($exibe['descricao'] ?? 'Descrição não disponível') . '<br>';
            echo '<strong>Departamento:</strong> ' . ($exibe['departamento'] ?? 'Departamento não informado') . '<br>';
            
            if (!empty($exibe['foto1'])) {
                echo '<img src="' . htmlspecialchars($exibe['foto1']) . '" alt="Imagem do produto">';
            } else {
                echo '<em>Imagem não disponível</em>';
            }

            echo '</div>';
        }
    ?>
</body>
</html>
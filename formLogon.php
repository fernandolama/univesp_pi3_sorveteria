<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sorveteria Maranata - Logon de Usuário</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        .navbar {
            margin-bottom: 0;
        }
        .container-fluid {
            margin-top: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
        include 'conexao.php';
        include 'nav.php';
        include 'cabecalho.html';
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <h2 class="text-center">Logon de Usuário</h2>

                <form method="post" action="validaUsuario.php" name="logon">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control" required id="email" placeholder="Digite seu email">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input name="senha" type="password" class="form-control" required id="senha" placeholder="Digite sua senha">
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary btn-block">
                        <span class="glyphicon glyphicon-ok"></span> Entrar
                    </button>
                </form>

                <div class="text-center" style="margin-top: 20px;">
                    <a href="formUsuario.php" class="btn btn-link">Ainda não sou cadastrado</a>
                    <a href="esqueciSenha.php" class="btn btn-link">Esqueci minha senha</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'rodape.html'; ?>
</body>
</html>
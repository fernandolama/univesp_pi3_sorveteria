<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: formLogon.php');
    exit;
}

include 'conexao.php';
include 'nav.php';
include 'cabecalho.html';

// Consulta as vendas com os dados do produto e do comprador
$sql = "SELECT v.*, 
               p.produto, 
               u.nome, 
               u.sobrenome 
        FROM vendas v
        JOIN produtos p ON v.id_produto = p.id
        JOIN usuarios u ON v.id_comprador = u.id_user
        ORDER BY u.nome, v.data ASC";
$stmt = $conexao->query($sql);
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agrupar as vendas por usuário e, dentro de cada usuário, por data (formato 'd/m/Y')
$grouped = [];
foreach ($vendas as $venda) {
    // Cria o nome do comprador (usuário) combinando nome e sobrenome
    $usuario = trim($venda['nome'] . ' ' . $venda['sobrenome']);
    // Formata a data para agrupar por dia
    $data = date('d/m/Y', strtotime($venda['data']));
    $grouped[$usuario][$data][] = $venda;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Gestão de Vendas - Administração</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS e Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- jQuery e Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    .usuario-header {
      background-color: #0077cc;
      color: #fff;
      padding: 10px;
      margin-top: 20px;
      border-radius: 4px;
    }
    .data-header {
      background-color: #5bc0de;
      color: #fff;
      padding: 8px;
      border-radius: 4px;
      margin-top: 15px;
    }
    table {
      margin-top: 10px;
    }
    .table > tbody > tr > td {
      vertical-align: middle;
    }
    .btn-voltar {
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="page-header">
      <h1 class="text-center">Gestão de Vendas</h1>
    </header>
    
    <?php foreach ($grouped as $usuario => $vendasPorData): ?>
      <div class="usuario-header">
        <h2><?php echo htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8'); ?></h2>
      </div>
      
      <?php foreach ($vendasPorData as $data => $vendasList): ?>
        <div class="data-header">
          <h3><?php echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Ticket</th>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preço Unitário</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($vendasList as $venda): ?>
              <tr>
                <td><?php echo htmlspecialchars($venda['ticket'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($venda['produto'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($venda['quantidade'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>R$ <?php echo number_format($venda['valor'], 2, ',', '.'); ?></td>
                <td>R$ <?php echo number_format($venda['valor'] * $venda['quantidade'], 2, ',', '.'); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endforeach; ?>
    <?php endforeach; ?>
    
    <!-- Botão para voltar à página administrativa principal -->
    <div class="text-center btn-voltar">
      <a href="adm.php" class="btn btn-default">
        <i class="fa fa-arrow-left"></i> Voltar
      </a>
    </div>
  </div>
  
  <?php include 'rodape.html'; ?>
</body>
</html>
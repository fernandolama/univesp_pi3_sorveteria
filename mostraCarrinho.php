<?php
include 'conexao.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$total = 0;

if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $id => $qtd) {
        $consulta = $conexao->query("SELECT * FROM produtos WHERE id='$id'");
        $exibe = $consulta->fetch(PDO::FETCH_ASSOC);
        $total += $exibe['preco'] * $qtd;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Carrinho de Compras</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $id => $qtd) {
                        $consulta = $conexao->query("SELECT * FROM produtos WHERE id='$id'");
                        $exibe = $consulta->fetch(PDO::FETCH_ASSOC);
                        $totalItem = $exibe['preco'] * $qtd;
                        echo "<tr>";
                        echo "<td>{$exibe['produto']}</td>";
                        echo "<td>{$qtd}</td>";
                        echo "<td>R$ " . number_format($exibe['preco'], 2, ',', '.') . "</td>";
                        echo "<td>R$ " . number_format($totalItem, 2, ',', '.') . "</td>";
                        echo "<td>
                                <a href='adicionar_ao_carrinho.php?id={$id}' class='btn btn-success'>+</a>
                                <a href='decrementar_do_carrinho.php?id={$id}' class='btn btn-danger'>-</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Carrinho vazio.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <h2>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h2>
        <a href="index.php" class="btn btn-primary">Continuar Comprando</a>
        <a href="finalizarCompra.php" class="btn btn-success">Finalizar Compra</a>
    </div>
</body>
</html>
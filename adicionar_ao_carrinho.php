<?php
include 'conexao.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$id_prod = $_GET['id'];
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

if (!isset($_SESSION['carrinho'][$id_prod])) {
    $_SESSION['carrinho'][$id_prod] = 1;
} else {
    $_SESSION['carrinho'][$id_prod] += 1;
}

header('Location: mostraCarrinho.php');
exit;
?>

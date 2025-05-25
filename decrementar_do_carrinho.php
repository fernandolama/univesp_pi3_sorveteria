<?php
include 'conexao.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id_prod = $_GET['id'];

if (isset($_SESSION['carrinho'][$id_prod])) {
    $_SESSION['carrinho'][$id_prod] -= 1;
    if ($_SESSION['carrinho'][$id_prod] <= 0) {
        unset($_SESSION['carrinho'][$id_prod]);
    }
}

header('Location: mostraCarrinho.php');
exit;
?>

<?php
session_start();

include 'conexao.php';

$data = date('Y-m-d');
$ticket = uniqid();
$id_user = $_SESSION['id'];

if (!empty($_SESSION['carrinho'])) {
    // Inicia uma transação no banco de dados
    $conexao->beginTransaction();

    try {
        // Para cada item no carrinho
        foreach ($_SESSION['carrinho'] as $id => $qnt) {
            // Busca o preço do produto
            $consulta = $conexao->query("SELECT * FROM produtos WHERE id='$id'");
            $exibe = $consulta->fetch(PDO::FETCH_ASSOC);
            $preco = $exibe['preco'];
            
            // Calculando o valor total (preço * quantidade)
            $valor_total = $preco * $qnt;

            // Inserindo a venda na tabela "vendas"
            $inserir = $conexao->prepare("INSERT INTO vendas (ticket, id_comprador, id_produto, quantidade, data, valor) 
                                          VALUES (:ticket, :id_user, :id_produto, :quantidade, :data, :valor)");

            // Bind dos parâmetros
            $inserir->bindParam(':ticket', $ticket);
            $inserir->bindParam(':id_user', $id_user);
            $inserir->bindParam(':id_produto', $id);
            $inserir->bindParam(':quantidade', $qnt);
            $inserir->bindParam(':data', $data);
            $inserir->bindParam(':valor', $valor_total);

            // Executando a query
            $inserir->execute();
        }

        // Se não ocorrer nenhum erro, comita a transação
        $conexao->commit();

        // Limpa o carrinho após o sucesso
        unset($_SESSION['carrinho']); // ou $_SESSION['carrinho'] = [];
        
        echo "Compra realizada com sucesso! Carrinho de compras limpo!<br>";

    } catch (Exception $e) {
        // Caso ocorra um erro, faz o rollback e exibe a mensagem de erro
        $conexao->rollBack();
        echo "Erro ao realizar a compra: " . $e->getMessage();
    }

} else {
    echo "Carrinho vazio!";
}

include 'fim.php';
?>

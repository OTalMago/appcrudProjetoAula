<?php
include 'db.php';
include 'shopcart_controller.php';
session_start(); // Certifique-se de que a sessão está iniciada

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Armazena informações do usuário
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
$id_usuario = $_SESSION['id']; // Obter o ID do usuário da sessão

// Verifique se o ID do usuário está definido e não está vazio
if (empty($id_usuario)) {
    $_SESSION['erro_compra'] = "ID do usuário não encontrado.";
    header("Location: shopcart_erro_compra.php");
    exit();
}

// Função para salvar o pedido no banco de dados (exemplo simples)
function salvarPedido($carrinho, $total, $id_usuario) {
    global $conn;
    
    $data_pedido = date('Y-m-d H:i:s');

    // Tenta inserir o pedido no banco
    try {
        $sql = "INSERT INTO pedidos (id_usuario, total, data_pedido) VALUES ('$id_usuario', '$total', '$data_pedido')";
        
        if ($conn->query($sql) === TRUE) {
            $pedido_id = $conn->insert_id;  // Obtém o ID do pedido recém-criado
            
            // Inserir itens do pedido no banco
            foreach ($carrinho as $id_produto => $item) {
                $produto_id = $item['id_produto'];
                $quantidade = $item['quantidade'];
                $subtotal = $item['subtotal'];

                $sql_item = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, subtotal) 
                             VALUES ('$pedido_id', '$produto_id', '$quantidade', '$subtotal')";
                if ($conn->query($sql_item) === FALSE) {
                    throw new Exception("Erro ao inserir item do pedido: " . $conn->error);
                }
            }

            return true;  // Pedido e itens foram inseridos com sucesso
        } else {
            throw new Exception("Erro ao inserir pedido: " . $conn->error);
        }
    } catch (Exception $e) {
        // Retorna o erro para ser tratado na página de erro
        return $e->getMessage();
    }
}

// Verifica se o botão de finalizar compra foi acionado
if (isset($_POST['acao']) && $_POST['acao'] == 'finalizar') {
    $total = calcularTotalCarrinho();  // Calcula o total da compra

    // Salva o pedido no banco de dados
    $erro = salvarPedido($_SESSION['carrinho'], $total, $id_usuario); // Passa o ID do usuário

    if ($erro === true) {
        // Limpa o carrinho da sessão
        unset($_SESSION['carrinho']);

        // Redireciona para a página de confirmação de compra ou pagamento
        header("Location: shopcart_sucesso_compra.php");
        exit();
    } else {
        // Se algo falhou ao salvar o pedido, redireciona para a página de erro com a mensagem de erro
        $_SESSION['erro_compra'] = $erro;  // Armazena o erro na sessão
        header("Location: shopcart_erro_compra.php");
        exit();
    }
} else {
    // Se a ação não for válida, redireciona para a página inicial ou carrinho
    header("Location: index.php");
    exit();
}
?>
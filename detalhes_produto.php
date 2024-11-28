<?php
include 'principal_controller.php'; // Gerencia a sessão
include 'produtos_controller.php'; // Inclui o controlador de produtos

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redireciona para a página de login
    exit();
}

// Verifica se o ID do produto foi passado
if (isset($_GET['id'])) {
    $product = getProduct($_GET['id']); // Obtém os detalhes do produto
} else {
    header("Location: produtos_cadastro.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Produto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Garante que o corpo ocupe pelo menos a altura total da tela */
        }
        .container {
            flex: 1; /* Permite que o container expanda para ocupar espaço */
        }
        .product-image {
            max-width: 300px;
            margin-bottom: 20px;
        }
        .product-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?> <!-- Incluindo o cabeçalho -->

    <div class="container mt-5">
        <h2 class="text-center">Detalhes do Produto</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="product-details">
                    <?php if ($product): ?>
                        <h4><?php echo $product['nome']; ?></h4>
                        <img src="<?php echo $product['url_img']; ?>" alt="Imagem do produto" class="product-image img-fluid">
                        <p><strong>ID:</strong> <?php echo $product['id']; ?></p>
                        <p><strong>Descrição:</strong> <?php echo $product['descricao']; ?></p>
                        <p><strong>Marca:</strong> <?php echo $product['marca']; ?></p>
                        <p><strong>Modelo:</strong> <?php echo $product['modelo']; ?></p>
                        <p><strong>Valor Unitário:</strong> R$ <?php echo number_format($product['valorunitario'], 2, ',', '.'); ?></p>
                        <p><strong>Categoria:</strong> <?php echo $product['categoria']; ?></p>
                    <?php else: ?>
                        <p>Produto não encontrado.</p>
                    <?php endif; ?>
                    <a href="produtos_cadastro.php" class="btn btn-primary mt-3">Voltar</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?> <!-- Incluindo o rodapé -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
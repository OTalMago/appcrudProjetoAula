<?php
include 'principal_controller.php'; 
include 'produtos_controller.php'; 


if (!isset($_SESSION['email'])) {
    header("Location: index.php"); 
    exit();
}


$products = getProducts();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh; 
            display: flex;
            flex-direction: column;
        }
        .container {
            flex: 1; 
        }
        .card {
            height: 100%; 
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?> 

    <div class="container mt-5">
        <h2 class="text-center">Vinhos</h2>
        <div class="row">
        <?php foreach ($products as $product): ?>
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <img src="<?php echo $product['url_img']; ?>" class="card-img-top" alt="Imagem do produto">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product['nome']; ?></h5>
                <p class="card-text"><strong>Valor:</strong> R$ <?php echo number_format($product['valorunitario'], 2, ',', '.'); ?></p>
                <p class="card-text"><strong>Descrição:</strong> <?php echo $product['descricao']; ?></p>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="detalhes_produto.php?id=<?php echo $product['id']; ?>" class="btn btn-danger">Ver Detalhes</a>
                    <form method="POST" action="principal_controller.php" class="d-inline">
                        <input type="hidden" name="id_produto" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="adicionar_produto" class="btn btn-success">Comprar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
include 'principal_controller.php'; // Inclua o controlador principal para gerenciar sessões

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redireciona para a página de login
    exit();
}

include 'header.php'; 
include 'produtos_controller.php';

// Pega todos os produtos para preencher os dados da tabela
$Products = getProducts();

// Variável que guarda o ID do produto que será editado
$ProductToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
// e se há um ID para edição de produto
if (isset($_GET['edit'])) {
    $ProductToEdit = getProducts($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Produtos</title>
    <script>
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('descricao').value = '';
            document.getElementById('marca').value = '';
            document.getElementById('modelo').value = '';
            document.getElementById('valoruni').value = '';
            document.getElementById('categoria').value = '';
            document.getElementById('url_img').value = '';
        }
    </script>
</head>
<body>
    <div class="container mt-3">
    <h2>Cadastro de Produtos</h2>
    <form method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo $ProductToEdit['id'] ?? ''; ?>">
        
        <label for="nome">Nome:</label>
        <input class="form-control" type="text" id="nome" name="nome" value="<?php echo $ProductToEdit['nome'] ?? ''; ?>" required><br>
        
        <label for="descricao">Descricao:</label>
        <input class="form-control" placeholder="Insira a descrição do produto aqui..." type="text" id="descricao" name="descricao" value="
        <?php echo $ProductToEdit['descricao'] ?? ''; ?>"><br>
        
        <label for="marca">Marca:</label>
        <input class="form-control" type="text" id="marca" name="marca" value="<?php echo $ProductToEdit['marca'] ?? ''; ?>"><br>

        <label for="mmodelo">Modelo:</label>
        <input class="form-control" type="text" id="modelo" name="modelo" value="<?php echo $ProductToEdit['modelo'] ?? ''; ?>"><br>
        
        <label for="valorunitario">Valor unitario:</label>
        <input class="form-control" type="number" id="valorunitario" name="valorunitario" required value="><br><?php echo $ProductToEdit['valorunitario'] ?? ''; ?>"><br>

        <label for="categoria">Categoria:</label>
        <input class="form-control" type="text" id="categoria" name="categoria" value="<?php echo $ProductToEdit['categoria'] ?? ''; ?>"><br>
        
        <label for="url_img">URL da imagem:</label>
        <input class="form-control" type="text" id="url_img" name="url_img" value="<?php echo $ProductToEdit['url_img'] ?? ''; ?>"><br><br>

        <div class="btn-group" style="gap: 10px;">
    <button type="submit" class="btn btn-success" name="save">Salvar</button>
    <button type="submit" class="btn btn-secondary" name="update">Atualizar</button>
    <button type="button" class="btn btn-warning" onclick="clearForm()">Novo</button>
    </div>
    </form>
    </div>

    <div class="container mt-3">
    <h2>Usuários Cadastrados</h2><br>
    <table class="table table-hover" border="1">
    <tr class="thead-dark">
        <th>ID</th>
        <th>Nome</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Valor unitário</th>
        <th>Categoria</th>
        <th>Imagem</th>
        <th>Ações</th>
    </tr>
    
    <?php foreach ($Products as $Product): ?>
        <tr>
            <td><?php echo $Product['id']; ?></td>
            <td><?php echo $Product['nome']; ?></td>
            <td><?php echo $Product['marca']; ?></td>
            <td><?php echo $Product['modelo']; ?></td>
            <td><?php echo $Product['valorunitario']; ?></td>
            <td><?php echo $Product['categoria']; ?></td>
            <td><img src="<?php echo $Product['url_img']; ?>" alt="Imagem do produto" width="60"></td>
            <td>
                
                <a href="detalhes_produto.php?id=<?php echo $Product['id']; ?>" class="btn btn-success btn-sm">Ver Detalhes</a>
                <a href="?edit=<?php echo $Product['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="?delete=<?php echo $Product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
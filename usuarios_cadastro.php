<?php 
include 'principal_controller.php'; 


if (!isset($_SESSION['email'])) {
    header("Location: index.php"); 
    exit();
}

include 'header.php'; 
include 'usuarios_controller.php';


$users = getUsers();


$userToEdit = null;


if (isset($_GET['edit'])) {
    $userToEdit = getUser($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuários</title>
    <script>
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('telefone').value = '';
            document.getElementById('email').value = '';
            document.getElementById('senha').value = '';
            document.getElementById('id').value = '';
        }
    </script>
</head>
<body>
    <div class="container mt-3">
    <h2>Cadastro de Usuários</h2>
    <form method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo $userToEdit['id'] ?? ''; ?>">
        
        <label for="nome">Nome:</label>
        <input class="form-control" type="text" id="nome" name="nome" value="<?php echo $userToEdit['nome'] ?? ''; ?>" required><br>
        
        <label for="telefone">Telefone:</label>
        <input class="form-control" placeholder="(00) 0 0000-0000" type="text" id="telefone" name="telefone" value="<?php echo $userToEdit['telefone'] ?? ''; ?>" required><br>
        
        <label for="email">Email:</label>
        <input class="form-control" placeholder="example@gmail.com" type="email" id="email" name="email" value="<?php echo $userToEdit['email'] ?? ''; ?>" required><br>
        
        <label for="senha">Senha:</label>
        <input class="form-control" type="password" id="senha" name="senha" required><br><br>
        
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
            <th>Telefone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
      
        <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['nome']; ?></td>
                    <td><?php echo $user['telefone']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <a href="?edit=<?php echo $user['id']; ?>" class="btn btn-secondary btn-sm">Editar</a>
                        <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm ('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                    </td>
                </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
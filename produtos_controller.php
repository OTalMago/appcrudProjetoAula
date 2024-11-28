<?php
include 'db.php';

function saveProduct($nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, marca, modelo, valorunitario, categoria, url_img) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img);
    return $stmt->execute();
}

function getProducts() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProduct($id) {
    global $conn; 
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); 
}

function updateProduct($id, $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img) {
    global $conn;
    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, marca = ?, modelo = ?, valorunitario = ?, categoria = ?, url_img = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $id);
    return $stmt->execute();
}

function deleteProduct($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        saveProduct($_POST['nome'], $_POST['descricao'], $_POST['marca'], $_POST['modelo'], $_POST['valorunitario'], $_POST['categoria'], $_POST['url_img']);
    } elseif (isset($_POST['update'])) {
        updateProduct($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['marca'], $_POST['modelo'], $_POST['valorunitario'], $_POST['categoria'], $_POST['url_img']);
    }
}

// Processamento da exclusão
if (isset($_GET['delete'])) {
    deleteProduct($_GET['delete']);
}
?>
<?php
session_start();

// Verifica se a compra foi bem-sucedida
if (isset($_SESSION['erro_compra'])) {
    // Se houver um erro, exibe a mensagem de erro
    echo "<h2>Erro ao processar a compra: " . $_SESSION['erro_compra'] . "</h2>";
    unset($_SESSION['erro_compra']); // Limpa a mensagem de erro
} else {
    // Mensagem de sucesso
    echo "<h2>Compra realizada com sucesso!</h2>";
    echo "<p>Obrigado pela sua compra. Você pode voltar ao site clicando no botão abaixo.</p>";
    echo '<a href="index.php" class="btn btn-primary">Voltar ao site</a>';
}
?>
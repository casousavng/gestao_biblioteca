<?php
require_once '../../backoffice/controllers/emprestimo_livro_controller.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?mensagem=" . urlencode("Por favor, faça login para continuar."));
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Realizar Empréstimo</title>
    <link rel="stylesheet" type="text/css" href="../style/style_pagina.css">
</head>
<body>
    <div class="container">
        <h1>Realizar Empréstimo de Livro</h1>
        <form method="post" action="">
            <label for="idLivro">ID do Livro:</label>
            <input type="number" id="idLivro" name="idLivro" required><br>

            <label for="ccLeitor">CC do Leitor:</label>
            <input type="text" id="ccLeitor" name="ccLeitor" required><br>

            <button type="submit">Realizar Empréstimo</button>
        </form>

        <br>
        <button onclick="window.location.href='livros.php'">Voltar à Página Anterior</button>
        <br><br>
        <button onclick="window.location.href='../../logout.php'">SAIR</button>

        <?php if (!empty($mensagem)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
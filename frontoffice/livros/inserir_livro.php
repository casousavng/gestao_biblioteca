<?php
require_once '../../backoffice/controllers/inserir_livro_controller.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Inserir Livro</title>
    <!-- Arquivo CSS externo -->
    <link rel="stylesheet" type="text/css" href="../style/style_pagina.css">
</head>
<body>
<div class="container">
    <h1>Inserir Livro</h1>
    <form method="post" action="">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br>

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required><br>

        <label for="editora">Editora:</label>
        <input type="text" id="editora" name="editora"><br>

        <label for="anoPublicacao">Ano de Publicação:</label>
        <input type="number" id="anoPublicacao" name="anoPublicacao" required><br>

        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required><br>

        <label for="numeroCopias">Número de Cópias:</label>
        <input type="number" id="numeroCopias" name="numeroCopias" value="1" required><br>

        <label for="genero">Gênero:</label>
        <select id="genero" name="genero" required>
            <option value="">Selecione o gênero</option>
            <option value="Ficção Científica">Ficção Científica</option>
            <option value="Fantasia">Fantasia</option>
            <option value="Romance">Romance</option>
            <option value="Mistério">Mistério</option>
            <option value="Suspense">Suspense</option>
            <option value="História">História</option>
            <option value="Biografia">Biografia</option>
            <option value="Autoajuda">Autoajuda</option>
            <option value="Poesia">Poesia</option>
            <option value="Infantil">Infantil</option>
        </select><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="">Selecione o estado</option>
            <option value="Disponivel">Disponível</option>
            <option value="Emprestado">Emprestado</option>
            <option value="Reservado">Reservado</option>
            <option value="Danificado">Danificado</option>
        </select><br>

        <button type="submit">Inserir Livro</button>
        
    </form>

    <br>
    <button onclick="window.location.href='livros.php'">Voltar à Página Anterior</button>    
    <br><br>
    <button onclick="window.location.href='../../logout.php'">SAIR</button>


        <!-- Exibe a mensagem -->
    <?php if (!empty($mensagem)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

</div>
</body>
</html>

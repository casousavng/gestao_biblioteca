<?php
require_once '../../backoffice/controllers/gerir_utilizador_controller.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pesquisar e Gerir Utilizadores</title>
    <!-- Arquivo CSS externo -->
    <link rel="stylesheet" type="text/css" href="../style/style_pagina.css">
</head>
<body>
<div class="container">
    <!-- Formulário para Atualizar Utilizador -->
    <h1>Atualizar Utilizador</h1>
    <form method="post" action="">
        <input type="hidden" name="acao" value="atualizar">
        <label for="id_utilizador">ID do Utilizador:</label>
        <input type="number" id="id_utilizador" name="id_utilizador"><br>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome"><br>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="">Selecione</option>
            <option value="Leitor">Leitor</option>
            <option value="Bibliotecario">Bibliotecario</option>
        </select><br>

        <label for="contacto">Contacto:</label>
        <input type="text" id="contacto" name="contacto"><br>

        <label for="morada">Morada:</label>
        <input type="text" id="morada" name="morada"><br>

        <label for="numeroCC">Número de CC:</label>
        <input type="text" id="numeroCC" name="numeroCC"><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado">
            <option value="Ativo">Ativo</option>
            <option value="Inativo">Inativo</option>
            <option value="Suspenso">Suspenso</option>
        </select><br>

        <button type="submit">Atualizar</button>
    </form>

    <br>
    <button onclick="window.location.href='utilizadores.php'">Voltar à Gestão de Utilizadores</button>    
    <br><br>
    <button onclick="window.location.href='../../logout.php'">SAIR</button>

        <!-- Exibe a mensagem -->
    <?php if (!empty($mensagem)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>


</div>
</body>
</html>

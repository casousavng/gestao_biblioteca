<?php
require_once '../../backoffice/controllers/pesquisar_livro_controller.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?mensagem=" . urlencode("Por favor, faça login para continuar."));
    exit;
}

// Determina o tipo de utilizador
$user_type = strtolower($_SESSION['user_type']); // Assumindo que 'user_type' foi configurado durante o login
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pesquisar Livro</title>
    <!-- Arquivo CSS externo -->
    <link rel="stylesheet" type="text/css" href="../style/style_pagina.css">
</head>
<body>
    <div class="container">
        <h1>Pesquisar Livro</h1>
        <form method="post" action="">
            <label for="titulo">Título do Livro:</label>
            <input type="text" id="titulo" name="titulo"><br>

            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor"><br>

            <label for="editora">Editora:</label>
            <input type="text" id="editora" name="editora"><br>

            <label for="anoPublicacao">Ano de Publicação:</label>
            <input type="number" id="anoPublicacao" name="anoPublicacao"><br>

            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn"><br>

            <label for="genero">Gênero:</label>
            <select id="genero" name="genero">
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
            <select id="estado" name="estado">
                <option value="">Selecione o estado</option>
                <option value="Disponivel">Disponível</option>
                <option value="Emprestado">Emprestado</option>
                <option value="Reservado">Reservado</option>
                <?php if ($user_type == 'bibliotecario'): ?>
                    <option value="Danificado">Danificado</option>
                <?php endif; ?>
            </select><br>

            <button type="submit">Pesquisar</button>
        </form>

        <br>
    <button onclick="window.location.href='livros.php'">Voltar à Página Anterior</button>    
    <br><br>
    <button onclick="window.location.href='../../logout.php'">SAIR</button>

        <!-- Exibe a mensagem -->
        <?php if (!empty($mensagem)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
    </div> <!-- Fecha container -->

    <?php if (!empty($resultados)): ?>
        <div class="container2">
            <h2>Resultados da Pesquisa</h2>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Editora</th>
                    <th>Ano de Publicação</th>
                    <th>ISBN</th>
                    <th>Número de Cópias</th>
                    <th>Gênero</th>
                    <th>Estado</th>
                </tr>
                <?php foreach ($resultados as $livro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($livro['ID_LIVRO'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['TITULO'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['AUTOR'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['EDITORA'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['ANOPUBLICACAO'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['ISBN'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['NUMEROCOPIAS'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['GENERO'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['ESTADO'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div> <!-- Fecha container2 -->
    <?php endif; ?>

</body>
</html>

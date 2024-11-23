<?php
require_once '../../backoffice/controllers/gerir_livro_controller.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?mensagem=" . urlencode("Por favor, faça login para continuar."));
    exit;
}

// Determina o tipo de utilizador
$user_type = strtolower($_SESSION['user_type']);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Livros</title>
    <link rel="stylesheet" type="text/css" href="../style/style_pagina.css">
</head>
<body>
    <div class="container">
        <h1>Atualizar Livros</h1>
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
                <option value="Danificado">Danificado</option>
            </select><br>

            <button type="submit">Pesquisar</button>
        </form>

        <br>
        <button onclick="window.location.href='livros.php'">Voltar à Página Anterior</button>    
        <br><br>
        <button onclick="window.location.href='../../logout.php'">SAIR</button>

        <?php if (!empty($mensagem)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
    </div>

    <?php if (!empty($resultados)): ?>
        <div class="container2">
            <h2>Resultados da Pesquisa</h2>
            <form method="post" action="">
                <table border="1">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Editora</th>
                        <th>Ano de Publicação</th>
                        <th>ISBN</th>
                        <th>Estado</th>
                        <th>Cópias</th>
                        <th>Atualizar</th>
                    </tr>
                    <?php foreach ($resultados as $livro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($livro['ID_LIVRO']); ?></td>
                            <td><?php echo htmlspecialchars($livro['TITULO']); ?></td>
                            <td><?php echo htmlspecialchars($livro['AUTOR']); ?></td>
                            <td><?php echo htmlspecialchars($livro['EDITORA']); ?></td>
                            <td><?php echo htmlspecialchars($livro['ANOPUBLICACAO']); ?></td>
                            <td><?php echo htmlspecialchars($livro['ISBN']); ?></td>
                            <td>
                                <select name="estado_<?php echo $livro['ID_LIVRO']; ?>">
                                    <option value="Disponivel" <?php echo $livro['ESTADO'] == 'Disponivel' ? 'selected' : ''; ?>>Disponível</option>
                                    <option value="Emprestado" <?php echo $livro['ESTADO'] == 'Emprestado' ? 'selected' : ''; ?>>Emprestado</option>
                                    <option value="Reservado" <?php echo $livro['ESTADO'] == 'Reservado' ? 'selected' : ''; ?>>Reservado</option>
                                    <option value="Danificado" <?php echo $livro['ESTADO'] == 'Danificado' ? 'selected' : ''; ?>>Danificado</option>
                                </select>
                            </td>
                            <td>
                                <select name="copias_<?php echo $livro['ID_LIVRO']; ?>">
                                    <?php for ($i = 0; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo $livro['NUMEROCOPIAS'] == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="atualizar" value="<?php echo $livro['ID_LIVRO']; ?>">Atualizar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>

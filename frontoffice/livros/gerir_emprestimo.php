<?php
// Inclui o controlador para manipulação de dados
require_once '../../backoffice/controllers/gerir_emprestimo_controller.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Empréstimos</title>
    <link rel="stylesheet" type="text/css" href="../style/style_pagina.css">
</head>
<body>
    <div class="container"> <!-- Adicionando o container para manter o estilo -->
        <h1>Gerenciar Empréstimos</h1>

        <!-- Formulário de Pesquisa -->
        <form method="POST" action="gerir_emprestimo.php">
            <h2>Pesquisar Empréstimos</h2>
            <label for="idLivro">ID do Livro:</label>
            <input type="text" id="idLivro" name="idLivro" value="<?= $_POST['idLivro'] ?? ''; ?>"><br><br>

            <label for="ccLeitor">Número de CC do Leitor:</label>
            <input type="text" id="ccLeitor" name="ccLeitor" value="<?= $_POST['ccLeitor'] ?? ''; ?>"><br><br>

            <label for="estado">Estado do Empréstimo:</label>
            <select id="estado" name="estado">
                <option value="">Selecione</option>
                <option value="Ativo" <?= isset($_POST['estado']) && $_POST['estado'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                <option value="Devolvido" <?= isset($_POST['estado']) && $_POST['estado'] == 'Devolvido' ? 'selected' : ''; ?>>Devolvido</option>
                <option value="Atrasado" <?= isset($_POST['estado']) && $_POST['estado'] == 'Atrasado' ? 'selected' : ''; ?>>Atrasado</option>
            </select><br><br>

            <button type="submit" name="acao" value="pesquisar">Pesquisar</button>
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

        <!-- Tabela de Resultados -->
        <?php if (!empty($resultados)): ?>
            <div class="container2"> <!-- Adicionando container2 para manter a estrutura -->
                <h2>Empréstimos Encontrados</h2>
                <table border="1">
                        <tr>
                            <th>ID Empréstimo</th>
                            <th>Título do Livro</th>
                            <th>Nome do Leitor</th>
                            <th>Data do Empréstimo</th>
                            <th>Estado Atual</th>
                            <th>Alterar Estado</th>
                        </tr>
                        <?php foreach ($resultados as $emprestimo): ?>
                            <tr>
                                <td><?= htmlspecialchars($emprestimo['ID_EMPRESTIMO']); ?></td>
                                <td><?= htmlspecialchars($emprestimo['TITULO']); ?></td>
                                <td><?= htmlspecialchars($emprestimo['NOME']); ?></td>
                                <td><?= htmlspecialchars($emprestimo['DATAEMPRESTIMO']); ?></td>
                                <td><?= htmlspecialchars($emprestimo['ESTADO']); ?></td>
                                <td>
                                    <!-- Formulário para alterar o estado -->
                                    <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="acao" value="alterar_estado">
                                        <input type="hidden" name="idEmprestimo" value="<?= htmlspecialchars($emprestimo['ID_EMPRESTIMO']); ?>">
                                        <select name="novoEstado">
                                            <option value="Devolvido" <?= $emprestimo['ESTADO'] == 'Devolvido' ? 'selected' : ''; ?>>Devolvido</option>
                                            <option value="Atrasado" <?= $emprestimo['ESTADO'] == 'Atrasado' ? 'selected' : ''; ?>>Atrasado</option>
                                            <option value="Ativo" <?= $emprestimo['ESTADO'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                                        </select>
                                        <button type="submit">Alterar Estado</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </table>
            </div> <!-- Fecha container2 -->
            <?php endif; ?>


</body>
</html>
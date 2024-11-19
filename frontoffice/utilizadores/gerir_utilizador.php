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
        <!-- Formulário de pesquisa -->
        <h1>Pesquisar e Gerir Estado Utilizador</h1>
        <form method="post" action="">
            <input type="hidden" name="acao" value="pesquisar">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome"><br>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo">
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
                <option value="">Selecione o estado</option>
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
                <option value="Suspenso">Suspenso</option>
            </select><br>

            <button type="submit">Pesquisar</button>
        </form>

            <br>
            <button onclick="window.location.href='utilizadores.php'">Voltar à Gestão de Utilizadores</button>    
            <br><br>
            <button onclick="window.location.href='../../../index.php'">Voltar à Página Inicial</button>

    </div> <!-- Fecha container -->

    <?php if (!empty($resultados)): ?>
        <div class="container2">
            <h2>Resultados da Pesquisa</h2>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Contacto</th>
                    <th>Morada</th>
                    <th>Número CC</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($resultados as $utilizador): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($utilizador['ID_UTILIZADOR'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($utilizador['NOME'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($utilizador['TIPO'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($utilizador['CONTACTO'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($utilizador['MORADA'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($utilizador['NUMEROCC'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($utilizador['ESTADO'] ?? 'N/A'); ?></td>
                        <td>
                            <form method="post" action="" style="display:inline;">
                                <input type="hidden" name="acao" value="alterar_estado">
                                <input type="hidden" name="id_utilizador" value="<?php echo htmlspecialchars($utilizador['ID_UTILIZADOR']); ?>">
                                <select name="estado">
                                    <option value="Ativo" <?php if ($utilizador['ESTADO'] == 'Ativo') echo 'selected'; ?>>Ativo</option>
                                    <option value="Inativo" <?php if ($utilizador['ESTADO'] == 'Inativo') echo 'selected'; ?>>Inativo</option>
                                    <option value="Suspenso" <?php if ($utilizador['ESTADO'] == 'Suspenso') echo 'selected'; ?>>Suspenso</option>
                                </select>
                                <button type="submit">Alterar Estado</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div> <!-- Fecha container2 -->
    <?php endif; ?>

        <!-- Exibe a mensagem -->
    <?php if (!empty($mensagem)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

</body>
</html>

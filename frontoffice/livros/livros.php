<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?mensagem=" . urlencode("Por favor, faça login para continuar."));
    exit;
}

// Obtém o tipo de utilizador da sessão
$user_type = $_SESSION['user_type'] ?? null;

if ($user_type !== null) {
    // Converte o tipo de usuário para UTF-8 caso necessário
    $user_type = mb_convert_encoding($user_type, 'UTF-8', 'auto');
    $user_type = mb_strtolower($user_type, 'UTF-8'); // Compatível com acentos
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Livros</title>
    <link rel="stylesheet" type="text/css" href="../style/style_inicio.css">

</head>
<body>
<div class="container">
    <h1>Gestão de Livros</h1>
    <ul>
        <?php if ($user_type == 'leitor'): ?>
            <li><a href="pesquisar_livro.php">Pesquisar Livro</a></li>
        <?php endif; ?>
        <?php if ($user_type != 'leitor'): ?>
            <li><a href="inserir_livro.php">Inserir Livros</a></li>
            <li><a href="editar_livro.php">Editar Livros</a></li>
            <li><a href="pesquisar_livro.php">Pesquisar Livro</a></li>
            <li><a href="emprestimo_livro.php">Emprestar Livros</a></li>
            <li><a href="gerir_emprestimo.php">Gerir Emprestimo</a></li>
        <?php endif; ?>
    </ul>
    <ul>
        <li style="margin-top: 40px;"></li>
        <li><a href="../../menu.php">Voltar à Página Inicial</a></li>
        <li><a href="../../logout.php">SAIR</a></li>
    </ul>
</div>
</body>
</html>

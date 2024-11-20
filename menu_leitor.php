<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php?mensagem=" . urlencode("Por favor, faça login para continuar."));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <!-- Arquivo CSS externo -->
    <link rel="stylesheet" type="text/css" href="frontoffice/style/style_inicio.css">
</head>
<body>
<div class="container">
    <h1>Bem-vindo à Biblioteca</h1>
    <nav>
        <ul>
            <li><a href="frontoffice/livros/pesquisar_livro.php">Pesquisa de Livros</a></li>
        </ul>
    </nav>
</div>
</body>
</html>
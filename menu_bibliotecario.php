<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php?mensagem=" . urlencode("Por favor, faça login para continuar."));
    exit;
}
// Determina o tipo de utilizador
$user_type = strtolower($_SESSION['user_type']); // Assumindo que 'user_type' foi configurado durante o login
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
            <li><a href="frontoffice/livros/livros.php">Gestão de Livros</a></li>
            <?php if ($user_type == 'bibliotecario'): ?>
                <li><a href="frontoffice/utilizadores/utilizadores.php">Gestão de Utilizadores</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</body>
</html>
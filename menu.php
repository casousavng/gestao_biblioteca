<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?mensagem=" . urlencode("Por favor, faça login para continuar."));
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
    <title>Página Inicial</title>
    <!-- Arquivo CSS externo -->
    <link rel="stylesheet" type="text/css" href="frontoffice/style/style_inicio.css">
</head>
<body>
<div class="container">
    <h1>Bem-vindo à Biblioteca</h1>
    <p>Olá, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Utilizador'); ?>! Você entrou como <strong><?php echo htmlspecialchars($user_type); ?></strong>.</p>
    
    <nav>
        <ul>
            <?php if ($user_type == 'leitor'): ?>
                <li><a href="frontoffice/livros/pesquisar_livro.php">Pesquisa de Livros</a></li>
            <?php endif; ?>
            <?php if ($user_type != 'leitor'): ?>
                <li><a href="frontoffice/livros/livros.php">Gestão de Livros</a></li>
                <li><a href="frontoffice/utilizadores/utilizadores.php">Gestão de Utilizadores</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <footer>
        <a href="logout.php">Sair</a>
    </footer>
</div>
</body>
</html>

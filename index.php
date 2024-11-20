

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="frontoffice/style/style_inicio.css"> <!-- Caminho para seu arquivo CSS -->
</head>
<body>
    <div class="container">
        <h1>Sistema de Gestão de Biblioteca</h1>
        <h2>Login</h2>
        <form action="backoffice/controllers/login_controller.php" method="post">
            <label for="user_id">ID do Utilizador ou Número do CC:</label>
            <input type="text" id="user_id" name="user_id" required>
            <br><br>
            <button type="submit">Entrar</button>
        </form>

        <!-- Exibir mensagem de erro se existir -->
        <?php if (isset($_GET['mensagem']) && !empty($_GET['mensagem'])): ?>
            <p class="mensagem" style="color: red;">
                <?php echo htmlspecialchars($_GET['mensagem']); ?>
            </p>
        <?php endif; ?>
    </div>
</body>
</html>

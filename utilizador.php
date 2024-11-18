<?php
// Configurações de conexão com o banco de dados Oracle
$host = 'localhost';
$port = '1521';
$sid = 'xe';
$username = 'c##biblioteca';
$password = 'senha123';

$dsn = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SID=$sid)))";

try {
    // Conexão com o banco de dados Oracle usando PDO
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar ao Oracle: " . $e->getMessage();
    exit;
}

// Inicializa a variável de resultados
$resultados = [];

// Inserção de novo utilizador
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'inserir') {
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $contacto = $_POST['contacto'];
    $morada = $_POST['morada'];
    $numeroCC = $_POST['numeroCC'];
    $estado = $_POST['estado'] ?? 'Ativo';

    // Verifica se o número de CC já existe
    $sqlVerificaCC = "SELECT COUNT(*) FROM \"UTILIZADOR\" WHERE \"NUMEROCC\" = :numeroCC";
    $stmt = $conn->prepare($sqlVerificaCC);
    $stmt->bindParam(':numeroCC', $numeroCC);
    $stmt->execute();
    $ccExistente = $stmt->fetchColumn();

    if ($ccExistente > 0) {
        echo "<p>Erro: O número de CC já está em uso. Por favor, altere o número de CC ou corrija os dados.</p>";
    } elseif (empty($tipo)) {
        echo "<p>Erro: O campo 'Tipo' é obrigatório. Selecione 'Leitor' ou 'Bibliotecário'.</p>";
    } else {

    // Utiliza a sequência seq_utilizador para pegar o próximo ID
    $sql = "INSERT INTO \"UTILIZADOR\" (\"ID_UTILIZADOR\", \"NOME\", \"TIPO\", \"CONTACTO\", \"MORADA\", \"NUMEROCC\", \"ESTADO\") 
            VALUES (seq_utilizador.NEXTVAL, :nome, :tipo, :contacto, :morada, :numeroCC, :estado)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':contacto', $contacto);
    $stmt->bindParam(':morada', $morada);
    $stmt->bindParam(':numeroCC', $numeroCC);
    $stmt->bindParam(':estado', $estado);
    
    try {
        $stmt->execute();
        echo "<p>Utilizador inserido com sucesso!</p>";
    } catch (PDOException $e) {
        echo "Erro ao inserir utilizador: " . $e->getMessage();
    }
}
}

// Atualização ou alteração de utilizador
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'atualizar') {
    $id_utilizador = $_POST['id_utilizador'];
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $contacto = $_POST['contacto'];
    $morada = $_POST['morada'];
    $numeroCC = $_POST['numeroCC'];
    $estado = $_POST['estado'];

    $sql = "UPDATE \"UTILIZADOR\" 
            SET \"NOME\" = :nome, \"TIPO\" = :tipo, \"CONTACTO\" = :contacto, \"MORADA\" = :morada, \"NUMEROCC\" = :numeroCC, \"ESTADO\" = :estado
            WHERE \"ID_UTILIZADOR\" = :id_utilizador";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_utilizador', $id_utilizador);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':contacto', $contacto);
    $stmt->bindParam(':morada', $morada);
    $stmt->bindParam(':numeroCC', $numeroCC);
    $stmt->bindParam(':estado', $estado);
    
    try {
        $stmt->execute();
        echo "<p>Dados do utilizador atualizados com sucesso!</p>";
    } catch (PDOException $e) {
        echo "Erro ao atualizar utilizador: " . $e->getMessage();
    }
}

// Alteração de estado do utilizador (Ativar/Inativar/Suspender)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'alterar_estado') {
    $id_utilizador = $_POST['id_utilizador'];
    $estado = $_POST['estado'];

    $sql = "UPDATE \"UTILIZADOR\" 
            SET \"ESTADO\" = :estado 
            WHERE \"ID_UTILIZADOR\" = :id_utilizador";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_utilizador', $id_utilizador);
    $stmt->bindParam(':estado', $estado);

    try {
        $stmt->execute();
        echo "<p>Estado do utilizador alterado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "Erro ao alterar estado do utilizador: " . $e->getMessage();
    }
}

// Pesquisa de utilizadores
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'pesquisar') {
    $nome = $_POST['nome'] ?? null;
    $tipo = $_POST['tipo'] ?? null;
    $contacto = $_POST['contacto'] ?? null;
    $morada = $_POST['morada'] ?? null;
    $numeroCC = $_POST['numeroCC'] ?? null;
    $estado = $_POST['estado'] ?? null;

    $sql = "SELECT \"ID_UTILIZADOR\", \"NOME\", \"TIPO\", \"CONTACTO\", \"MORADA\", \"NUMEROCC\", \"ESTADO\" 
            FROM \"UTILIZADOR\" 
            WHERE 1=1"; // Condição sempre verdadeira para facilitar a adição das outras condições

    if (!empty($nome)) {
        $sql .= " AND LOWER(\"NOME\") LIKE LOWER(:nome)";
    }
    if (!empty($tipo)) {
        $sql .= " AND LOWER(\"TIPO\") LIKE LOWER(:tipo)";
    }
    if (!empty($contacto)) {
        $sql .= " AND LOWER(\"CONTACTO\") LIKE LOWER(:contacto)";
    }
    if (!empty($morada)) {
        $sql .= " AND LOWER(\"MORADA\") LIKE LOWER(:morada)";
    }
    if (!empty($numeroCC)) {
        $sql .= " AND LOWER(\"NUMEROCC\") LIKE LOWER(:numeroCC)";
    }
    if (!empty($estado)) {
        $sql .= " AND LOWER(\"ESTADO\") = LOWER(:estado)";
    }

    $stmt = $conn->prepare($sql);

    if (!empty($nome)) {
        $stmt->bindValue(':nome', '%' . $nome . '%');
    }
    if (!empty($tipo)) {
        $stmt->bindValue(':tipo', '%' . $tipo . '%');
    }
    if (!empty($contacto)) {
        $stmt->bindValue(':contacto', '%' . $contacto . '%');
    }
    if (!empty($morada)) {
        $stmt->bindValue(':morada', '%' . $morada . '%');
    }
    if (!empty($numeroCC)) {
        $stmt->bindValue(':numeroCC', '%' . $numeroCC . '%');
    }
    if (!empty($estado)) {
        $stmt->bindValue(':estado', $estado);
    }

    try {
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao pesquisar utilizadores: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pesquisar e Gerenciar Utilizadores</title>
</head>
<body>
    <h1>Pesquisar, Inserir e Atualizar Utilizadores</h1>

    <!-- Formulário de pesquisa -->
    <h2>Pesquisar Utilizadores</h2>
    <form method="post" action="">
        <input type="hidden" name="acao" value="pesquisar">
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
            <option value="">Selecione o estado</option>
            <option value="Ativo">Ativo</option>
            <option value="Inativo">Inativo</option>
            <option value="Suspenso">Suspenso</option>
        </select><br>

        <button type="submit">Pesquisar</button>
    </form>

    <?php if (!empty($resultados)): ?>
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
    <?php endif; ?>

    <!-- Formulário para Inserir Novo Utilizador -->
    <h2>Inserir Novo Utilizador</h2>
    <form method="post" action="">
        <input type="hidden" name="acao" value="inserir">
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

        <button type="submit">Inserir</button>
    </form>

    <!-- Formulário para Atualizar Utilizador -->
    <h2>Atualizar Utilizador</h2>
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
    <a href="index.php">Voltar à Página Inicial</a>
</body>
</html>

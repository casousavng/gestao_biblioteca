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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $titulo = $_POST['titulo'] ?? null;
    $autor = $_POST['autor'] ?? null;
    $editora = $_POST['editora'] ?? null;
    $anoPublicacao = $_POST['anoPublicacao'] ?? null;
    $isbn = $_POST['isbn'] ?? null;
    $genero = $_POST['genero'] ?? null;
    $estado = $_POST['estado'] ?? null;

    // Inicializa a consulta SQL base
    $sql = "SELECT \"ID_LIVRO\", \"TITULO\", \"AUTOR\", \"EDITORA\", \"ANOPUBLICACAO\", \"ISBN\", \"NUMEROCOPIAS\", \"GENERO\", \"ESTADO\" 
            FROM \"LIVRO\" 
            WHERE 1=1"; // A condição "1=1" garante que sempre seja válida e facilita a construção dinâmica da query

    // Adiciona condições dinamicamente com base nos campos preenchidos
    if (!empty($titulo)) {
        $sql .= " AND LOWER(\"TITULO\") LIKE LOWER(:titulo)";
    }
    if (!empty($autor)) {
        $sql .= " AND LOWER(\"AUTOR\") LIKE LOWER(:autor)";
    }
    if (!empty($editora)) {
        $sql .= " AND LOWER(\"EDITORA\") LIKE LOWER(:editora)";
    }
    if (!empty($anoPublicacao)) {
        $sql .= " AND \"ANOPUBLICACAO\" = :anoPublicacao";
    }
    if (!empty($isbn)) {
        $sql .= " AND LOWER(\"ISBN\") LIKE LOWER(:isbn)";
    }
    if (!empty($genero)) {
        $sql .= " AND LOWER(\"GENERO\") LIKE LOWER(:genero)";
    }
    if (!empty($estado)) {
        $sql .= " AND LOWER(\"ESTADO\") = LOWER(:estado)";
    }

    // Prepara e executa a consulta
    $stmt = $conn->prepare($sql);

    // Bind dos parâmetros dinamicamente
    if (!empty($titulo)) {
        $stmt->bindValue(':titulo', '%' . $titulo . '%');
    }
    if (!empty($autor)) {
        $stmt->bindValue(':autor', '%' . $autor . '%');
    }
    if (!empty($editora)) {
        $stmt->bindValue(':editora', '%' . $editora . '%');
    }
    if (!empty($anoPublicacao)) {
        $stmt->bindValue(':anoPublicacao', $anoPublicacao);
    }
    if (!empty($isbn)) {
        $stmt->bindValue(':isbn', '%' . $isbn . '%');
    }
    if (!empty($genero)) {
        $stmt->bindValue(':genero', '%' . $genero . '%');
    }
    if (!empty($estado)) {
        $stmt->bindValue(':estado', $estado);
    }

    // Executa a consulta e armazena os resultados
    try {
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Depuração: Verifica se não encontrou resultados
        if (empty($resultados)) {
            echo "<p>Nenhum livro encontrado com os critérios informados.</p>";
        }
    } catch (PDOException $e) {
        echo "Erro ao buscar livros: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pesquisar Livro</title>
</head>
<body>
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
        <input type="text" id="genero" name="genero"><br>

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

    <?php if (!empty($resultados)): ?>
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
    <?php endif; ?>
    <a href="index.php">Voltar à Página Inicial</a>
</body>
</html>

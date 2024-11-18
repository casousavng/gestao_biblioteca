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

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editora = $_POST['editora'];
    $anoPublicacao = $_POST['anoPublicacao'];
    $isbn = $_POST['isbn'];
    $numeroCopias = $_POST['numeroCopias'];
    $genero = $_POST['genero'];
    $estado = $_POST['estado'];

    // Insere o livro na tabela
    $sql = "INSERT INTO livro (id_livro, titulo, autor, editora, anoPublicacao, isbn, numeroCopias, genero, estado) 
            VALUES (seq_livro.NEXTVAL, :titulo, :autor, :editora, :anoPublicacao, :isbn, :numeroCopias, :genero, :estado)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':editora', $editora);
    $stmt->bindParam(':anoPublicacao', $anoPublicacao);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->bindParam(':numeroCopias', $numeroCopias);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':estado', $estado);

    try {
        $stmt->execute();
        echo "Livro inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir livro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Inserir Livro</title>
</head>
<body>
    <h1>Inserir Livro</h1>
    <form method="post" action="">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br>

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required><br>

        <label for="editora">Editora:</label>
        <input type="text" id="editora" name="editora"><br>

        <label for="anoPublicacao">Ano de Publicação:</label>
        <input type="number" id="anoPublicacao" name="anoPublicacao" required><br>

        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required><br>

        <label for="numeroCopias">Número de Cópias:</label>
        <input type="number" id="numeroCopias" name="numeroCopias" value="1" required><br>

        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero"><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="">Selecione o estado</option>
            <option value="Disponivel">Disponivel</option>
            <option value="Emprestado">Emprestado</option>
            <option value="Reservado">Reservado</option>
            <option value="Danificado">Danificado</option>
        </select><br>

        <button type="submit">Inserir Livro</button>
    </form>
    <a href="index.php">Voltar à Página Inicial</a>
</body>
</html>

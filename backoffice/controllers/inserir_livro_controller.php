<?php

// Configurações de conexão com o banco de dados Oracle
require_once 'db.php';

// Inicializa a variável de mensagem
$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $editora = $_POST['editora'] ?? '';
    $anoPublicacao = $_POST['anoPublicacao'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $numeroCopias = $_POST['numeroCopias'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // Validação simples (você pode adicionar mais validações se necessário)
    if (empty($titulo) || empty($autor) || empty($isbn)) {
        $mensagem = "Erro: Os campos Título, Autor e ISBN são obrigatórios.";
    } else {
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
            $mensagem = "Livro inserido com sucesso!";
        } catch (PDOException $e) {
            $mensagem = "Erro ao inserir livro: " . $e->getMessage();
        }
    }
}

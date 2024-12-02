<?php

// Configurações de conexão com o banco de dados Oracle
require_once 'db.php';

// Inicializa a variável de mensagem
$mensagem = "";

// Inicializa a variável de resultados
$resultados = [];

// Alteração de estado do empréstimo (Ativo/Devolvido/Atrasado)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'alterar_estado') {
    $idEmprestimo = $_POST['idEmprestimo'];
    $novoEstado = $_POST['novoEstado'];

    $sql = "UPDATE \"EMPRESTIMO\" 
            SET \"ESTADO\" = :novoEstado 
            WHERE \"ID_EMPRESTIMO\" = :idEmprestimo";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idEmprestimo', $idEmprestimo);
    $stmt->bindParam(':novoEstado', $novoEstado);

    try {
        $stmt->execute();
        $mensagem = "Estado do empréstimo alterado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao alterar estado do empréstimo: " . $e->getMessage();
    }
}

// Pesquisa de empréstimos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'pesquisar') {
    $idLivro = $_POST['idLivro'] ?? null;
    $ccLeitor = $_POST['ccLeitor'] ?? null;
    $estado = $_POST['estado'] ?? null;

    $sql = "SELECT e.\"ID_EMPRESTIMO\", l.\"TITULO\", u.\"NOME\", e.\"DATAEMPRESTIMO\", e.\"ESTADO\"
        FROM \"EMPRESTIMO\" e
        JOIN \"LIVRO\" l ON e.\"ID_LIVRO\" = l.\"ID_LIVRO\"
        JOIN \"UTILIZADOR\" u ON e.\"ID_UTILIZADOR\" = u.\"ID_UTILIZADOR\"
        WHERE 1=1"; // Filtro inicial sempre verdadeiro

    if (!empty($idLivro)) {
        $sql .= " AND l.\"ID_LIVRO\" = :idLivro";
    }
    if (!empty($ccLeitor)) {
        $sql .= " AND u.\"NUMEROCC\" = :ccLeitor";
    }
    if (!empty($estado)) {
        $sql .= " AND e.\"ESTADO\" = :estado";
    }

    $stmt = $conn->prepare($sql);

    if (!empty($idLivro)) {
        $stmt->bindValue(':idLivro', $idLivro);
    }
    if (!empty($ccLeitor)) {
        $stmt->bindValue(':ccLeitor', $ccLeitor);
    }
    if (!empty($estado)) {
        $stmt->bindValue(':estado', $estado);
    }

    try {
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $mensagem = "Erro ao pesquisar empréstimos: " . $e->getMessage();
    }
}
?>
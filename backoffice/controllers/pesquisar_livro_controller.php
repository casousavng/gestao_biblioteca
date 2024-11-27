<?php

// Configurações de conexão com o banco de dados Oracle
require_once 'db.php';

// Inicializa a variável de mensagem
$mensagem = "";

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
    $ordenarPor = $_POST['ordenarPor'] ?? null; // Nova variável para a ordenação

    // Inicializa a consulta SQL base
    $sql = "SELECT \"ID_LIVRO\", \"TITULO\", \"AUTOR\", \"EDITORA\", \"ANOPUBLICACAO\", \"ISBN\", \"NUMEROCOPIAS\", \"GENERO\", \"ESTADO\" 
            FROM \"LIVRO\" 
            WHERE 1=1";

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

    // Adiciona a cláusula ORDER BY com base no valor de ordenarPor
    if (!empty($ordenarPor)) {
        if ($ordenarPor === 'titulo') {
            $sql .= " ORDER BY \"TITULO\" ASC";
        } elseif ($ordenarPor === 'anoPublicacao') {
            $sql .= " ORDER BY \"ANOPUBLICACAO\" ASC";
        }
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
            $mensagem = "Nenhum livro encontrado com os critérios informados.";
        }
    } catch (PDOException $e) {
        $mensagem =  "Erro ao procurar livros: " . $e->getMessage();
    }
}
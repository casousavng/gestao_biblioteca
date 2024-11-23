<?php
require_once 'db.php'; // Arquivo de configuração da conexão com o banco de dados

// Inicializa a variável de mensagem
$mensagem = "";

// Inicializa a variável de resultados
$resultados = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o formulário é para atualizar
    if (isset($_POST['atualizar'])) {
        // Recebe o ID do livro a ser atualizado
        $livroId = $_POST['atualizar'];
        $estado = $_POST['estado_' . $livroId];
        $copias = $_POST['copias_' . $livroId];

        // Chama a função para atualizar o livro
        atualizarLivro($livroId, $estado, $copias, $conn);
        $mensagem = "Livro atualizado com sucesso!";
    } else {
        // Pesquisa de livros
        // Obtém os dados do formulário de pesquisa
        $titulo = $_POST['titulo'] ?? null;
        $autor = $_POST['autor'] ?? null;
        $editora = $_POST['editora'] ?? null;
        $anoPublicacao = $_POST['anoPublicacao'] ?? null;
        $isbn = $_POST['isbn'] ?? null;
        $genero = $_POST['genero'] ?? null;
        $estado = $_POST['estado'] ?? null;

        // Consulta SQL para pesquisar livros
        $sql = "SELECT \"ID_LIVRO\", \"TITULO\", \"AUTOR\", \"EDITORA\", \"ANOPUBLICACAO\", \"ISBN\", \"NUMEROCOPIAS\", \"GENERO\", \"ESTADO\" 
                FROM \"LIVRO\" 
                WHERE 1=1"; // A condição "1=1" garante que a consulta seja sempre válida

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

            // Verifica se não encontrou resultados
            if (empty($resultados)) {
                $mensagem = "Nenhum livro encontrado com os critérios informados.";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao procurar livros: " . $e->getMessage();
        }
    }
}

/**
 * Função para atualizar o estado e o número de cópias de um livro
 */// Função para atualizar o estado e número de cópias de um livro
function atualizarLivro($livroId, $estado, $copias, $conn) {
    try {
        $sql = "UPDATE \"LIVRO\" 
                SET \"ESTADO\" = :estado, \"NUMEROCOPIAS\" = :copias
                WHERE \"ID_LIVRO\" = :livroId";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':estado', $estado);
        $stmt->bindValue(':copias', $copias);
        $stmt->bindValue(':livroId', $livroId);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao atualizar livro: " . $e->getMessage();
    }
}

?>

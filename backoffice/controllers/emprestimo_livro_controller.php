<?php

require_once 'db.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idLivro = $_POST['idLivro'] ?? null;
    $ccLeitor = $_POST['ccLeitor'] ?? null;

    if ($idLivro && $ccLeitor) {
        try {
            // Verificar se o livro está disponível
            $stmt = $conn->prepare("SELECT \"NUMEROCOPIAS\", \"ESTADO\" FROM \"LIVRO\" WHERE \"ID_LIVRO\" = :idLivro");
            $stmt->bindValue(':idLivro', $idLivro);
            $stmt->execute();
            $livro = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$livro || $livro['NUMEROCOPIAS'] <= 0 || strtolower($livro['ESTADO']) != 'disponivel') {
                $mensagem = "Livro não disponível para empréstimo.";
            } else {
                // Verificar limite de empréstimos do leitor
                $stmt = $conn->prepare("SELECT COUNT(*) AS \"TOTAL_EMPRESTIMOS\" FROM \"EMPRESTIMO\" WHERE \"ID_UTILIZADOR\" = :ccLeitor AND \"ESTADO\" = 'Ativo'");
                $stmt->bindValue(':ccLeitor', $ccLeitor);
                $stmt->execute();
                $emprestimosAtivos = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($emprestimosAtivos && $emprestimosAtivos['TOTAL_EMPRESTIMOS'] >= 3) { // Limite de 3 empréstimos
                    $mensagem = "Leitor já atingiu o limite de empréstimos ativos.";
                } else {
                    // Obter ID do utilizador a partir do número de CC
                    $stmt = $conn->prepare("SELECT \"ID_UTILIZADOR\" FROM \"UTILIZADOR\" WHERE \"NUMEROCC\" = :ccLeitor");
                    $stmt->bindValue(':ccLeitor', $ccLeitor);
                    $stmt->execute();
                    $utilizador = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$utilizador) {
                        $mensagem = "Leitor não encontrado.";
                    } else {
                        // Registrar o empréstimo (usar a sequência para o ID do empréstimo)
                        $idUtilizador = $utilizador['ID_UTILIZADOR'];
                        $stmt = $conn->prepare("INSERT INTO \"EMPRESTIMO\" (\"ID_EMPRESTIMO\", \"ID_LIVRO\", \"ID_UTILIZADOR\", \"DATAEMPRESTIMO\", \"ESTADO\") 
                                               VALUES (seq_emprestimo.NEXTVAL, :idLivro, :idUtilizador, SYSDATE, 'Ativo')");
                        $stmt->bindValue(':idLivro', $idLivro);
                        $stmt->bindValue(':idUtilizador', $idUtilizador);
                        $stmt->execute();

                        // Atualizar estoque do livro
                        $stmt = $conn->prepare("UPDATE \"LIVRO\" SET \"NUMEROCOPIAS\" = \"NUMEROCOPIAS\" - 1 WHERE \"ID_LIVRO\" = :idLivro");
                        $stmt->bindValue(':idLivro', $idLivro);
                        $stmt->execute();

                        $mensagem = "Empréstimo realizado com sucesso!";
                    }
                }
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao realizar empréstimo: " . $e->getMessage();
        }
    } else {
        $mensagem = "Por favor, forneça o ID do livro e o CC do leitor.";
    }
}
?>
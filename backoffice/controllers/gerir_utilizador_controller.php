<?php

// Configurações de conexão com o banco de dados Oracle
require_once 'db.php';

// Inicializa a variável de mensagem
$mensagem = "";

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
        $mensagem = "Erro: O número de CC já está em uso. Por favor, altere o número de CC ou corrija os dados.";
    } elseif (empty($tipo)) {
        $mensagem = "Erro: O campo 'Tipo' é obrigatório. Selecione 'Leitor' ou 'Bibliotecário'.";
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
        $mensagem = "Utilizador inserido com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao inserir utilizador: " . $e->getMessage();
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
        $mensagem = "Dados do utilizador atualizados com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao atualizar utilizador: " . $e->getMessage();
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
        $mensagem ="Estado do utilizador alterado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao alterar estado do utilizador: " . $e->getMessage();
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
        $mensagem = "Erro ao pesquisar utilizadores: " . $e->getMessage();
    }
}
?>
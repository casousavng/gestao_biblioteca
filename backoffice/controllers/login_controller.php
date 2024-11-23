<?php
// Inicia a sessão
session_start();

// Configuração de conexão com o banco de dados
require 'db.php';

// Inicialização da variável de mensagem
$mensagem = "";

// Verificação do método de requisição
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber o valor digitado pelo usuário
    $user_id = trim($_POST['user_id']);

    // Consulta para verificar se o ID ou número CC pertence a um utilizador
    $sqlVerificaUsuario = "SELECT \"TIPO\", \"NOME\", \"ESTADO\" 
                           FROM \"UTILIZADOR\" 
                           WHERE (\"ID_UTILIZADOR\" = :user_id OR \"NUMEROCC\" = :user_id)";
    $stmt = $conn->prepare($sqlVerificaUsuario);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Verifica o estado do utilizador de forma insensível a maiúsculas/minúsculas
            if (strtolower($usuario['ESTADO']) == 'ativo') {
                // Armazena as informações do utilizador na sessão
                $_SESSION['user_type'] = strtolower($usuario['TIPO']); // Salva o tipo do utilizador
                $_SESSION['user_name'] = $usuario['NOME']; // Salva o nome do utilizador
                $_SESSION['user_id'] = $user_id; // Salva o ID ou CC do utilizador logado

                // Redireciona para a página principal
                header("Location: ../../menu.php");
                exit;
            } else {
                // Utilizador inativo ou suspenso
                $mensagem = "Utilizador Inativo ou Suspenso. Por favor, contacte o Gestor da Biblioteca.";
            }
        } else {
            // Utilizador não encontrado
            $mensagem = "ID ou número CC inválido.";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro ao consultar o banco de dados: " . $e->getMessage();
    }
} else {
    $mensagem = "Método de requisição inválido.";
}

// Voltar para a página de login com a mensagem
header("Location: ../../index.php?mensagem=" . urlencode($mensagem));
exit;
?>

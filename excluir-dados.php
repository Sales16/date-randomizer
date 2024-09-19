<?php 
session_start();
require_once('../arquivos/config.php');
if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
    unset($_SESSION['user']);
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    if ($acao === 'excluirDados') {
        $stmt = $conexao->prepare("DELETE FROM lugares WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "<div class='sucesso'><p>Dados excluidos com sucesso!</p></div>";
            $stmt_update = $conexao->prepare("UPDATE usuarios SET import = 0 WHERE id = ?");
            $stmt_update->bind_param("i", $user_id);
            $stmt_update->execute();
        } else {
            echo "<div class='erro'><p>Nenhum dado excluido!</p></div>";
        }
        $stmt_update->close();
    } elseif ($acao === 'excluirConta') {
        $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<div class='sucesso'><p>Conta excluida com sucesso!</p></div>";
                unset($_SESSION['user']);
                unset($_SESSION['senha']);
                unset($_SESSION['user_id']);
                header('Location: login.php');
            } else {
                echo "<div class='erro'><p>Conta não encontrada!</p></div>";
            }
        } else {
            echo "<div class='erro'><p>Erro ao excluir a conta!</p></div>";
        }
    } else {
        echo "<div class='erro'><p>Ação inválida!</p></div>";
        
    }
    $stmt->close();
}
$conexao->close();
exit();
?>
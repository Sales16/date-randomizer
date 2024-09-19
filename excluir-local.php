<?php
session_start();
require_once('../arquivos/config.php');
if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
    unset($_SESSION['user']);
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM lugares WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Lugar excluído com sucesso!";
    } else {
        echo "Erro ao excluir o lugar.";
    }

    $stmt->close();
    $conexao->close();

    header('Location: index.php');
    exit();
}
?>
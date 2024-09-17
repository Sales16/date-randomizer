<?php 
session_start();
require_once('../arquivos/config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user']) || !isset($_SESSION['senha']) || !isset($_SESSION['user_id'])) {
    unset($_SESSION['user']);
    unset($_SESSION['senha']);
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$username = $_POST['username'];

$sql = $conexao->prepare("SELECT id FROM usuarios WHERE user = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $import_user_id = $row['id'];

    // Preparar e executar a consulta para obter os dados da tabela lugares
    $sql_import = $conexao->prepare("SELECT * FROM lugares WHERE user_id = ?");
    $sql_import->bind_param("i", $import_user_id);
    $sql_import->execute();
    $sql_result = $sql_import->get_result();

    if ($sql_result->num_rows > 0) {
        $sql_insert = "INSERT INTO lugares (nome, local, observacao, preco, nota, jaFomos, user_id) SELECT nome, local, observacao, preco, nota, jaFomos, ? FROM lugares WHERE user_id = ?";
        $stmt_insert = $conexao->prepare($sql_import);
        $stmt_insert->bind_param("ii", $user_id, $import_user_id);
        if ($stmt_import->execute()) {
            echo "<div class='sucesso'><p>Dados importados com sucesso!</p></div>";
        } else {
            echo "<div class='erro'><p>Erro ao importar!</p></div>";
        }
    } else {
        echo "<div class='erro'><p>Nenhum dado encontrado!</p></div>";
    }
}else {
    echo "<div class='erro'><p>Usuario não encontrado!</p></div>";
}
$conexao->close();
?>
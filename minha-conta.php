<?php
session_start();
require_once('../arquivos/config.php');
if (!isset($_SESSION['user']) || !isset($_SESSION['senha']) || !isset($_SESSION['user_id'])) {
    unset($_SESSION['user']);
    unset($_SESSION['senha']);
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $conexao->prepare("SELECT import FROM usuarios WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- STATUS BAR COLORIDA -->
    <meta name="theme-color" content="#23232e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" href="css/navbar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/minha-conta.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
    <title>Date Randomizer | Minha Conta</title>

    <title>Minha Conta</title>
</head>
<body>
    <script src="js/navbar.js" defer></script>
    <script src="js/scripts.js" defer></script>
    <nav>
        <a class="logo" href="index.php">Date Randomizer</a>
        <input type="checkbox" id="sidebar-active">
        <label for="sidebar-active" class="open-sidebar-button">
            <i class="bx bx-menu icone" id="menu-icon"></i>
        </label>
        <label id="overlay" for="sidebar-active"></label>
        <div class="links-container">
            <label for="sidebar-active" class="close-sidebar-button">
                <i class="bx bx-x icone" id="menu-icon"></i>
            </label>
            <a class="first" href="sobre.php">Sobre</a>
            <a href="adicionar.php">Adicionar Local</a>
            <a href="report.php">Report</a>
            <a href="https://github.com/Sales16?tab=repositories" target="_blank">Projetos</a>
            <a href="minha-conta.html">Minha Conta</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>
    <?php 
if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    if ($row['import'] == 0) { 
        $sql_import = "INSERT INTO lugares(nome, local, observacao, preco, nota, jaFomos, user_id) SELECT nome, local, observacao, preco, nota, jaFomos, ? FROM lugares_publicos";
        $stmt_import = $conexao->prepare($sql_import);
        $stmt_import->bind_param("i", $user_id);
        if ($stmt_import->execute()) {
            echo "<div class='sucesso'><p>Dados importados com sucesso!</p></div>";
            $sql_update = "UPDATE usuarios SET import = 1 WHERE id = ?";
            $stmt_update = $conexao->prepare($sql_update);
            $stmt_update->bind_param("i", $user_id);
            $stmt_update->execute();
        } else {
            echo "<div class='erro'><p>Erro ao importar!</p></div>";
        }
    } else {
        echo "<div class='erro'><p>Dados já importados!</p></div>";
    }
} else {
    echo "<div class='erro'><p>Usuario não encontrado!</p></div>";;
}
?>
    <h1 class="titulo">Minha Conta</h1>

    <div class="container">
        <form>
            <fieldset class="fieldset">
                <legend>Importar Tabela Publica</legend>
                <p class="texto">Deseja importar dados da tabela de Brasilia?</p>
                <button class="botao">Importar</button>
            </fieldset>
        </form>
    </div>

    <div class="container">
        <form id="importUser">
            <fieldset class="fieldset">
                <legend>Importar Tabela de outro Usuario</legend>
                <p class="texto">Deseja importar dados de outro usuario?</p>
                <input type="text" class="input" id="username" placeholder="Nome do usuario" required>
                <input class="botao" type="submit" name="import" id="import" value="Importar">
            </fieldset>
        </form>
        <div id="result"></div>
    </div>

    <div class="container">
        <fieldset class="fieldset">
            <legend>Conta</legend>
            <button class="botao" style="margin-top: 15px;">Sair da Conta</button>
        </fieldset>
        <fieldset class="warning">
            <p class="texto">Cuidado! Essas ações são irreversiveis</p>
            <button class="botao-warning" style="margin-bottom: 15px;">Apagar dados da conta</button>
            <button class="botao-warning">Excluir Conta</button>
        </fieldset>
    </div>
</body>
</html>
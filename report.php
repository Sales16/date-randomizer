<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- STATUS BAR COLORIDA -->
    <meta name="theme-color" content="#23232e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Date Randomizer | Report</title>

    <link rel="stylesheet" href="css/navbar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
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
            <a class="first" href="index.php">Início</a>
            <a href="adicionar.php">Adicionar Local</a>
            <a href="sobre.php">Sobre</a>
            <a href="https://github.com/Sales16?tab=repositories" target="_blank">Projetos</a>
            <a href="minha-conta.php">Minha Conta</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>

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
if (isset($_POST['enviar'])) {
    if (isset($_POST['mensagem']) && !empty($_POST['mensagem'])) {
        $mensagem = $_POST['mensagem'];
        $user_id = $_SESSION['user_id'];

        $stmt = $conexao->prepare("INSERT INTO report (mensagem, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $mensagem, $user_id);
        if ($stmt->execute()) {
            echo "<div class='sucesso'><p>Sua sugestão foi enviada com sucesso!</p></div>";
        } else {
            echo "<div class='erro'><p>Erro ao enviar sua sugestão. Tente novamente mais tarde.</p></div>";
        }
    }
    else {
        echo "<div class='erro'><p>Texto vazio ou nulo!</p></div>";
    }
}
?>

    <div class="container marginMeio">
        <form action="report.php" method="post">
            <fieldset style="text-align: center;">
                <legend>Reportar</legend>
                <textarea class="txtarea" name="mensagem" placeholder="Escreva aqui sua sugestão ou reporte um erro..."
                    required></textarea>
                <input class="botao" type="submit" name="enviar" id="enviar" value="Enviar">
            </fieldset>
        </form>
    </div>

</body>
</html>
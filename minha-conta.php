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
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="stylesheet" href="css/minha-conta.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
    <title>Date Randomizer | Minha Conta</title>

    <title>Minha Conta</title>
</head>
<body>
    <script src="js/navbar.js" defer></script>
    <script src="js/scripts.js" defer></script>
    <nav id="navbar">
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
            <a class="first" href="index.php">Inicio</a>
            <a href="sobre.php">Sobre</a>
            <a href="adicionar.php">Adicionar Local</a>
            <a href="report.php">Report</a>
            <a href="https://github.com/Sales16?tab=repositories" target="_blank">Projetos</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>

    <div class="alinhado">
        <a href="index.php" id="voltar">
            <i class='bx bx-arrow-back' id="icone-voltar"></i>
        </a>
        <h1 class="titulo">Minha Conta</h1>
    </div>

    <?php 
    if (isset($_POST['importarBrasilia'])) {
        $stmt = $conexao->prepare("SELECT import FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            if ($row['import'] == 0) { 
                $stmt_import = $conexao->prepare("INSERT INTO lugares(nome, local, observacao, preco, nota, jaFomos, user_id) SELECT nome, local, observacao, preco, nota, jaFomos, ? FROM lugares_brasilia");
                $stmt_import->bind_param("i", $user_id);
                if ($stmt_import->execute()) {
                    echo "<div class='sucesso'><p>Dados importados com sucesso!</p></div>";
                    $stmt_update = $conexao->prepare("UPDATE usuarios SET import = 1 WHERE id = ?");
                    $stmt_update->bind_param("i", $user_id);
                    $stmt_update->execute();
                    $stmt_update->close();
                } else {
                    echo "<div class='erro'><p>Erro ao importar!</p></div>";
                }
            } else {
                echo "<div class='erro'><p>Dados já importados!</p></div>";
            }
            $stmt_import->close();
        } else {
            echo "<div class='erro'><p>Usuario não encontrado!</p></div>";
        }
        $stmt->close();
    }
    if (isset($_POST['importarUser'])) {
        $username = $_POST['username'];

        $sql = $conexao->prepare("SELECT id FROM usuarios WHERE user = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $import_user_id = $row['id'];

            $sql_import = $conexao->prepare("SELECT * FROM lugares WHERE user_id = ?");
            $sql_import->bind_param("i", $import_user_id);
            $sql_import->execute();
            $sql_result = $sql_import->get_result();
        
            if ($sql_result->num_rows > 0) {
                $stmt_insert = $conexao->prepare("INSERT INTO lugares (nome, local, observacao, preco, nota, jaFomos, user_id) SELECT nome, local, observacao, preco, nota, jaFomos, ? FROM lugares WHERE user_id = ?");
                $stmt_insert->bind_param("ii", $user_id, $import_user_id);
                if ($stmt_insert->execute()) {
                    echo "<div class='sucesso'><p>Dados importados com sucesso!</p></div>";
                } else {
                    echo "<div class='erro'><p>Erro ao importar!</p></div>";
                }
                $stmt_insert->close();
            } else {
                echo "<div class='erro'><p>Nenhum dado encontrado!</p></div>";
            }
            $sql_import->close();
        }else {
            echo "<div class='erro'><p>Usuario não encontrado!</p></div>";
        }
        $sql->close();
    }
    $conexao->close();
?>


    <div class="container mt-0">
        <form action=" minha-conta.php" method="post">
            <fieldset class="fieldset">
                <legend>Importar Tabela Publica</legend>
                <p class="paragrafo">Deseja importar dados da tabela de Brasilia?</p>
                <input class="botao" type="submit" name="importarBrasilia" value="Importar">
            </fieldset>
        </form>
    </div>

    <div class="container">
        <form action="minha-conta.php" method="post">
            <fieldset class="fieldset">
                <legend>Importar Tabela de outro Usuario</legend>
                <p class="paragrafo">Deseja importar dados de outro usuario?</p>
                <input type="text" class="input" name="username" placeholder="Nome do usuario" required>
                <input class="botao" type="submit" name="importarUser" value="Importar">
            </fieldset>
        </form>
        <div id="result"></div>
    </div>

    <div class="container">
        <fieldset class="fieldset">
            <legend>Conta</legend>
            <a href="sair.php"><button class="botao mt-15">Sair da Conta</button></a>
        </fieldset>
        <fieldset class="warning">
            <p class="paragrafo">Cuidado! Essas ações são irreversiveis</p>
            <button class="botao-warning mb-15" onclick="confirmarAcao('excluirDados')">Apagar
                dados da conta</button>
            <button class="botao-warning" onclick="confirmarAcao('excluirConta')">Excluir Conta</button>
        </fieldset>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <p>&copy; 2024 Eduardo Sales. Todos os direitos reservados.</p>
            <div class="footer-nav">
                <a href="sobre.php">Sobre</a>
                <a href="minha-conta.php">Minha Conta</a>
            </div>
            <div class="social-links">
                <a href="https://github.com/Sales16" target="_blank" class="github">
                    <i class='bx bxl-github'></i>
                </a>
                <a href="https://linkedin.com/in/" target="_blank" class="linkedin">
                    <i class='bx bxl-linkedin'></i>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
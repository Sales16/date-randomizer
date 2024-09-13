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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
    <title>Date Randomizer | Adicionar Local</title>
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
            <a href="sobre.php">Sobre</a>
            <a href="report.php">Report</a>
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
        $user_id = $_SESSION['user_id'];

        $nome = $_POST['nome'];
        $local = $_POST['local'];
        $obs = $_POST['observacao'];
        $preco = $_POST['preco'];
        $nota = $_POST['nota'];
        $jaFomos = $_POST['jaFomos'];

        $stmt = $conexao->prepare("INSERT INTO lugares (user_id, nome, local, observacao, preco, nota, jaFomos) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssds", $user_id, $nome, $local, $obs, $preco, $nota, $jaFomos);

        if ($stmt->execute()) {
            echo "<div class='sucesso'><p>Lugar adicionado com sucesso!</p></div>";
        } else {
            echo "<div class='erro'><p>Erro ao adicionar!</p></div>";
        }
        $stmt->close();
    }
    $conexao->close();
    ?>

    <div class="container">
        <form action="adicionar.php" method="POST">
            <fieldset>
                <legend>Adicionar Local</legend>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="input" required>
                    <label for="nome" class="labelInput">Nome</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="local" id="local" class="input" required>
                    <label for="local" class="labelInput">Local</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="observacao" id="observacao" class="input" required>
                    <label for="observacao" class="labelInput">Observação</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="preco" id="preco" class="input" required>
                    <label for="preco" class="labelInput">Preço</label>
                </div>
                <div class="rangeDiv">
                    <input type="range" name="nota" id="nota" min="0" max="10" step="0.25" value="5"
                        oninput="updateValue(this.value)" class="rangeInput">
                    <label for="nota" class="labelNota">Nota: <span class="valor" id="valor">5</span></label>

                </div>
                <div class="radioDiv">
                    <p class="paragrafo">Já fomos:</p>
                    <input type="radio" id="sim" name="jaFomos" value="Sim" required>
                    <label for="sim">Sim</label>
                    <input type="radio" id="nao" name="jaFomos" value="Não" required>
                    <label for="nao">Não</label>
                </div>
                <input class="botao" type="submit" name="enviar" id="enviar" value="Enviar">
            </fieldset>
        </form>
    </div>


</body>

</html>
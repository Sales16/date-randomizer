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
    <link rel="stylesheet" href="css/footer.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
    <title>Date Randomizer | Editar Local</title>
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
            <a class="first" href="index.php">Incio</a>
            <a href="sobre.php">Sobre</a>
            <a href="report.php">Report</a>
            <a href="https://github.com/Sales16?tab=repositories" target="_blank">Projetos</a>
            <a href="minha-conta.php">Minha Conta</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>

    <a href="index.php" class="voltar">
        <i class='bx bx-arrow-back' id="icon-voltar"></i>
    </a>
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
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Get ID from URL or default to 0

    if ($id > 0) {
        $verificacao = $conexao->prepare("SELECT * FROM lugares WHERE id = ? AND user_id = ?");
        $verificacao->bind_param("ii", $id, $user_id);
        $verificacao->execute();
        $result = $verificacao->get_result();

        if ($result->num_rows === 0) {
            echo "<div class='erro'><p>Você não tem permissão para editar este local!</p></div>";
            exit();
        } else {
            $data = $result->fetch_assoc();
        }
        $verificacao->close();
    } else {
        echo "<div class='erro'><p>ID não fornecido!</p></div>";
        exit();
    }

    if (isset($_POST['atualizar'])) {
        $nome = $_POST['nome'];
        $local = $_POST['local'];
        $obs = $_POST['observacao'];
        $preco = $_POST['preco'];
        $nota = $_POST['nota'];
        $jaFomos = $_POST['jaFomos'];

        $stmt = $conexao->prepare("UPDATE lugares SET nome = ?, local = ?, observacao = ?, preco = ?, nota = ?, jaFomos = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssssdsii", $nome, $local, $obs, $preco, $nota, $jaFomos, $id, $user_id);

        if ($stmt->execute()) {
            echo "<div class='sucesso'><p>Dados atualizados com sucesso! Redirecionando...</p></div>";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 1050);
            </script>";
        } else {
            echo "<div class='erro'><p>Erro ao atualizar!</p></div>";
        }
        $stmt->close();
    }

    $conexao->close();
    ?>

    <div class="container marginMeio">
        <form action="editar.php?id=<?php echo $id; ?>" method="POST">
            <fieldset class="fieldset">
                <legend>Editar Local</legend>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="input"
                        value="<?php echo htmlspecialchars($data['nome']); ?>" required>
                    <label for="nome" class="labelInput">Nome</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="local" id="local" class="input"
                        value="<?php echo htmlspecialchars($data['local']); ?>" required>
                    <label for="local" class="labelInput">Local</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="observacao" id="observacao" class="input"
                        value="<?php echo htmlspecialchars($data['observacao']); ?>" required>
                    <label for="observacao" class="labelInput">Observação</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="preco" id="preco" class="input"
                        value="<?php echo htmlspecialchars($data['preco']); ?>" required>
                    <label for="preco" class="labelInput">Preço</label>
                </div>
                <div class="rangeDiv">
                    <input type="range" name="nota" id="nota" min="0" max="10" step="0.25"
                        value="<?php echo htmlspecialchars($data['nota']); ?>" oninput="updateValue(this.value)"
                        class="rangeInput">
                    <label for="nota" class="labelNota">Nota: <span class="valor"
                            id="valor"><?php echo htmlspecialchars($data['nota']); ?></span></label>
                </div>
                <div class="radioDiv">
                    <p class="jaFomos">Já fomos:</p>
                    <input type="radio" id="sim" name="jaFomos" value="Sim"
                        <?php echo ($data['jaFomos'] == 'Sim') ? 'checked' : ''; ?> required>
                    <label for="sim">Sim</label>
                    <input type="radio" id="nao" name="jaFomos" value="Não"
                        <?php echo ($data['jaFomos'] == 'Não') ? 'checked' : ''; ?> required>
                    <label for="nao">Não</label>
                </div>
                <input class="botao" type="submit" name="atualizar" id="atualizar" value="Salvar Alterações">
            </fieldset>
        </form>
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
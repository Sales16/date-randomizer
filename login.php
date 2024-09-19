<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Randomizer | Login</title>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
</head>
<script src="js/scripts.js" defer></script>

<body>
    <?php
    session_start();
    require_once('../arquivos/config.php');
    if (isset($_POST['login'])) {
        unset($_SESSION['user']);
        unset($_SESSION['user_id']);
        $user = $_POST['user'];
        $senha = $_POST['senha'];

        // Seleciona o usuário no banco de dados
        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE user = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows < 1) {
            // Usuário não encontrado
            echo "<div class='erro'><p>Usuário ou senha incorretos!</p></div>";
        } else {
            // Verifica a senha usando password_verify
            $user_data = $resultado->fetch_assoc();
            if (password_verify($senha, $user_data['senha'])) {
                // Senha correta, define a sessão e redireciona
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user_data['id'];
                header('Location: index.php');
                exit();
            } else {
                // Senha incorreta
                echo "<div class='erro'><p>Usuário ou senha incorretos!</p></div>";
            }
        }

        // Fecha a conexão
        $stmt->close();
        $conexao->close();
    }
    ?>
    <div class="container centralizado">
        <form action="login.php" method="POST">
            <fieldset class="fieldset">
                <legend class="login">Login</legend>
                <div class="inputBox">
                    <input type="text" name="user" id="user" class="input" autocomplete="off" required>
                    <label for="user" class="labelInput">Usuario:</label>
                </div>
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="input" autocomplete="off" required>
                    <label for="senha" class="labelInput">Senha:</label>
                </div>
                <input class="botao" type="submit" name="login" id="login" value="Login">
                <a href="cadastro.php" class="linkCadastro">Cadastre-se</a>
            </fieldset>
        </form>
    </div>
</body>

</html>
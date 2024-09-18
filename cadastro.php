<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Randomizer | Cadastro</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
</head>
<script src="js/scripts.js" defer></script>

<body>
    <?php
    if (isset($_POST['cadastro'])) {
        require_once('../arquivos/config.php');

        $user = $_POST['user'];
        $senha = $_POST['senha'];
        $senhaC = $_POST['senhaC'];

        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE user = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows >= 1) {
            // Usuário já existe
            echo "<div class='erro'><p>Usuário já cadastrado!</p></div>";
        } else {
            // Verifica se as senhas coincidem
            if ($senha != $senhaC) {
                echo "<div class='erro'><p>As senhas não coincidem!</p></div>";
            } else {
                // Insere o novo usuário na tabela 'usuarios'
                $stmt = $conexao->prepare("INSERT INTO usuarios (user, senha) VALUES (?, ?)");
                $stmt->bind_param("ss", $user, $senha); // Senha sem hashing
                if ($stmt->execute()) {
                    // Redireciona para a página de login após o cadastro
                    header('Location: login.php');
                    exit();
                } else {
                    echo "<div class='erro'><p>Erro ao cadastrar o usuário. Tente novamente mais tarde.</p></div>";
                }
            }
        }

        // Fecha as declarações e a conexão
        $stmt->close();
        $conexao->close();
    }
    ?>

    <div class="container centralizado">
        <form action="cadastro.php" method="post">
            <fieldset>
                <legend class="cadastro">Cadastro</legend>
                <div class="inputBox">
                    <input type="text" name="user" id="user" class="input" autocomplete="nope" required>
                    <label for="user" class="labelInput">Usuario:</label>
                </div>
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="input" autocomplete="new-password" required>
                    <label for="senha" class="labelInput">Senha:</label>
                </div>
                <div class="inputBox">
                    <input type="password" name="senhaC" id="senhaC" class="input" autocomplete="new-password" required>
                    <label for="senhaC" class="labelInput">Confirme a senha:</label>
                </div>
                <input class="botao" type="submit" name="cadastro" id="cadastro" value="Cadastro">
                <a class="linkCadastro" href="login.php">Conecte-se</a>

            </fieldset>
        </form>
    </div>
</body>

</html>
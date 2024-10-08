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
    <link rel="stylesheet" href="css/tabela.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
    <title>Date Randomizer</title>
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
            <a href="minha-conta.php">Minha Conta</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>
    <?php
    echo ('<h2 class="ola">Olá, ' . htmlspecialchars(ucfirst($_SESSION['user']), ENT_QUOTES, 'UTF-8') . '!</h2>');
    ?>
    <main class="principal">
        <?php
        if (!empty($_GET['pesquisa'])) {
            $pesquisa = '%' . $_GET['pesquisa'] . '%';
            $stmt = $conexao->prepare("SELECT * FROM lugares WHERE user_id = ? AND nome LIKE ?");
            $stmt->bind_param("is", $user_id, $pesquisa);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows == 0) {
                echo "<div class='erro'><p>Nenhum resultado encontrado!</p></div>";
                $stmt = $conexao->prepare("SELECT * FROM lugares WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $resultado = $stmt->get_result();
            }
        } else {
            $stmt = $conexao->prepare("SELECT * FROM lugares WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $resultado = $stmt->get_result();
        }
        ?>
        <div class="botoes">
            <button onclick="buscarLinhaAleatoria()" class="bt">Sortear</button>
            <button onclick="redirecionar()" id="sortearBtn" class="bt">Adicionar Local</button>
        </div>
        <div class="loading-container">
            <div class="loading-icon" id="loadingIcon"></div>
        </div>
        <div id="resultado"></div>
        <div class="box-pesquisar">
            <input type="search" class="pesquisar" id="pesquisar" placeholder="Pesquisar">
            <button class="bt-pesquisar" onclick="search()"><i class='bx bx-search-alt-2' id="icon-search"></i></button>
        </div>
        <?php
        if ($resultado->num_rows == 0) {
            echo "<div class='erro'><p>Nenhum local adicionado!</p></div>";
            $stmt = $conexao->prepare("UPDATE usuarios SET import = 0 WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
        } else {
            echo ('<div class="tabela-lugares">');
            echo ('<table class="tabela">');
            echo ('<thead class="tb-thead">');
            echo ('<tr>');
            echo ('<th scope="col">ID</th>');
            echo ('<th scope="col">NOME</th>');
            echo ('<th scope="col">LOCAL</th>');
            echo ('<th scope="col">OBSERVAÇÃO</th>');
            echo ('<th scope="col">PREÇO</th>');
            echo ('<th scope="col">NOTA</th>');
            echo ('<th scope="col">JÁ FOMOS</th>');
            echo ('<th scope="col">EDITAR</th>');
            echo ('<th scope="col">EXCLUIR</th>');
            echo ('</tr>');
            echo ('</thead>');
            echo ('<tbody class="tb-tbody">');
            $indice = 1; // Inicializando o índice sequencial
            while ($user_data = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $indice++ . "</td>"; // Mostrando o índice sequencial;
                echo "<td>" . $user_data['nome'] . "</td>";
                echo "<td>" . $user_data['local'] . "</td>";
                echo "<td>" . $user_data['observacao'] . "</td>";
                echo "<td>" . $user_data['preco'] . "</td>";
                echo "<td>" . $user_data['nota'] . "</td>";
                echo "<td>" . $user_data['jaFomos'] . "</td>";
                echo "<td class='acao'><a href='editar.php?id=" . $user_data['id'] . "'><img src='img/lapis.png' class='imagem' alt='Editar'></a></td>";
                echo "<td class='acao'><a href='excluir-local.php?id=" . $user_data['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este local?\")'><img class='imagem' src='img/x.png' alt='Excluir'></a></td>";
                echo "</tr>";
            }
            echo ('</tbody>');
            echo ('</table>');
            echo ('</div>');
        }
        $stmt->close();
        $conexao->close();
        ?>
    </main>

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
                <a href="https://linkedin.com/in/eduardo-sales16" target="_blank" class="linkedin">
                    <i class='bx bxl-linkedin'></i>
                </a>
            </div>
        </div>
    </footer>

</body>

</html>
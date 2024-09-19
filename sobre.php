<?php
    session_start();
    require_once('../arquivos/config.php');
    if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
        unset($_SESSION['user']);
        unset($_SESSION['user_id']);
        header('Location: login.php');
        exit();
    }
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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="shortcut icon" href="img/roleta.png" type="image/x-icon">
    <title>Date Randomizer | Sobre</title>
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
            <a href="report.php">Report</a>
            <a href="https://github.com/Sales16?tab=repositories" target="_blank">Projetos</a>
            <a href="minha-conta.php">Minha Conta</a>
            <a href="sair.php">Sair</a>
        </div>
    </nav>

    <a href="index.php" class="voltar">
        <i class='bx bx-arrow-back' id="icon-voltar"></i>
    </a>

    <div class="sobre">
        <h1 class="tituloSobre">Date Randomizer</h1>
        <p class="texto">Bem-vindo ao <strong>Date Randomizer</strong>! Criei este site para ajudar você a tomar uma
            decisão quando estiver em dúvida sobre qual lugar visitar. Se você já passou por aquele momento em que quer
            sair, mas não sabe para onde, este é o lugar certo para você!</p>

        <p class="texto">O <strong>Date Randomizer</strong> permite que você:</p>
        <ul class="lista-texto">
            <li>Adicione seus locais favoritos, como restaurantes, parques, cafés ou qualquer outro lugar especial.</li>
            <li>Tenha todos os seus lugares salvos e na palma da sua mão quando precisar de ideias para um passeio.</li>
            <li>Use o botão "Sortear" para deixar a decisão por conta da sorte e se surpreender com a sugestão de um
                lugar especial!</li>
        </ul>

        <p class="texto">É possivel tambem importar os dados de tabelas de outros usuarios e temos uma tabela padrão com
            alguns locais de Brasília para ser importada tambem. Essas opções estão acessiveis na aba <a
                href="minha-conta.php" class="linkSobre">Minha Conta</a>.</p>
        </p>

        <p class="texto">Nosso objetivo é tornar suas escolhas mais divertidas e descomplicadas. Com apenas alguns
            cliques, você terá sempre uma nova opção para explorar.</p>

        <p class="texto">Aproveite e comece a criar sua lista de lugares agora mesmo!</p>

        <p class="texto">Caso tenha alguma dúvida, sugestão ou encontre algum erro no site, não hesite em entrar em
            contato com a aba de <a href="report.php" class="linkSobre">Report</a>.</p>

        <h2 class="texto">Divirta-se!</h2>
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
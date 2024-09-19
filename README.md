# [DATE RANDOMIZER](https://dates.alwaysdata.net/)

O Date Randomizer é um projeto pessoal que visa ajudar usuários a decidir qual local visitar, entre uma lista de lugares que eles já gostaram ou que acham interessantes. A ideia é proporcionar uma maneira divertida e simples de sortear um local aleatoriamente, ideal para quem está em dúvida sobre o próximo passeio ou encontro.

O site está disponivel aqui: [DATE RANDOMIZER](https://dates.alwaysdata.net/)

O projeto está hospedado no [Alwaysdata](https://www.alwaysdata.com/en/), um serviço de hospedagem que oferece planos gratuitos, tornando acessível a criação e manutenção do site.

## Principais Funcionalidades

- Login e Cadastro: O site conta com uma tela de autenticação, permitindo que os usuários criem suas contas e façam login para acessar suas listas personalizadas de locais.

- Adicionar Locais: Após o login, o usuário tem acesso total ao sistema, onde tem uma tela para adicionar novos lugares, descrevendo locais que visitou ou que deseja visitar no futuro.

- Tabela de Locais: Na tela principal, o usuário encontra uma tabela organizada com todos os locais que adicionou. Cada entrada na tabela pode ser visualizada, e o usuário tem total controle sobre sua lista, podendo excluir e editar os dados de cada local separadamente.

- Sorteio de Local: Um botão na tela principal permite que o usuário sorteie um local aleatório da sua lista, ideal para quando há muitas opções e a indecisão bate.

- Tela de Report: Os usuários podem reportar possíveis erros ou sugerir melhorias através de uma tela dedicada para enviar feedback, garantindo a constante melhoria do site.

## Como Usar

1. Faça o cadastro ou login para acessar suas listas.
2. Adicione locais que você gosta ou deseja visitar.
3. Use a tabela para visualizar todos os lugares que você adicionou, podendo editar ou excluir locais.
4. Clique no botão de sorteio para decidir de forma divertida qual local visitar.
5. Caso encontre um erro ou tenha uma sugestão, utilize a tela de report para compartilhar seu feedback.

## Codigo SQL para a criação das tabelas

**Tabela Lugares**

CREATE TABLE lugares (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  nome VARCHAR(255) NOT NULL,
  local VARCHAR(255) NOT NULL,
  observacao TEXT NOT NULL,
  preco VARCHAR(255) NOT NULL,
  nota FLOAT NOT NULL,
  jaFomos VARCHAR(5) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES usuarios(id)
);

**Tabela Usuarios**

CREATE TABLE lugares (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(45) NOT NULL,
  senha VARCHAR(45) NOT NULL,
  import tinyint(1) DEFAULT 0,
);


**Tabela de Reports**

CREATE TABLE lugares (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  data TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  feito enum('sim','nao') NOT NULL DEFAULT 'nao',
  FOREIGN KEY (user_id) REFERENCES usuarios(id)
);

## CSS

  - navbar.css
    - Toda estilização nescessaria para a navbar.
  - geral.css
    - Estilização geral de todas as página, contém o css principal.
  - tabela.css
    - Estilização de todas as tabelas presentes.
  - formulario.css
    - Estilização de todos os forms presentes.
  - minha-conta.css
    - Estilização de algumas itens para a página minha-conta.php .
  - footer.css
    - Toda estilização nescessaria para o footer.

## IMG

  - lapis.png
    - Icone do botão editar da tabela principal.
  - x.png
    - Icone do botão excluir da tabela principal.
  - roleta.png
    - Favicon.
  - voltar.png
    - Icone do botão voltar presente em algumas páginas.

## JAVASCRIPT

  - navbar.js
    - Contém todo script nescessario para a navbar funcionar corretamente e ser responsiva.
  - scripts.js
    - Scripts gerais, inclui varias funções para facilitar a interação com o frontend, como redirecionamentos, manipulação com o DOM, requisições AJAX, etc.

## HTML/PHP

  - login.php
    - Página de login, com um forms para realizar o login (AINDA NÃO TEM SEGURANÇA DE SENHA).
  - cadastro.php
    - Página de cadastro, apenas com um forms para realizar o cadastro do usuario.
  - index.php
    - Página principal, com sua tabela pessoal.
  - adicionar.php
    - Página para adicionar os locais para a sua tabela.
  - editar.php
    - Página identica a adicionar.php, porém com outra lógica, e o forms ja vem preenhido.
  - excluir-local.php
    - Apenas um script php para excluir um local.
  - report.php
    - Página para reportar erros, ou enviar críticas\sugestões.
  - sortear.php
    - Script que faz o sorteio do local, ele é rodado com AJAX pelo javascript para não ser preciso recarregar a página.
  - sobre.php
    - Página falando um pouco sobre o Date Randomizer.
  - minha-conta.php
    - Página da conta do usuario, onde pode importar a tabela publica ou de outro usuario, excluir sua conta ou seus dados.
  - excluir-dados.php
    - Script que exclui todos os dados da conta ou exclui a conta permanentemente, rodado com AJAX pelo javascript.
  - sair.php
    - Script para sair da conta.
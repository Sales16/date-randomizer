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

SQL TABLE
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

SQL TABLE
CREATE TABLE lugares (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(45) NOT NULL,
  senha VARCHAR(45) NOT NULL,
);

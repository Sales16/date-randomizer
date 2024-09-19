<?php 
session_start();
require_once('../arquivos/config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
    unset($_SESSION['user']);
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit();
}

// Obtém o user_id da sessão
$user_id = $_SESSION['user_id'];

// Primeiro, recupera todos os lugares do usuário para atribuir IDs sequenciais
$sql = "SELECT * FROM lugares WHERE user_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Cria um array para armazenar os dados dos lugares com seus IDs sequenciais
$lugares = [];
$indice = 1;

while ($row = $result->fetch_assoc()) {
    // Armazena cada linha com um índice sequencial
    $lugares[] = array_merge($row, ['sequencial' => $indice++]);
}

$stmt->close();

// Verifica se há algum lugar para sortear
if (count($lugares) > 0) {
    // Sorteia um índice aleatório
    $randomIndex = array_rand($lugares);

    // Obtém o lugar sorteado
    $lugarSorteado = $lugares[$randomIndex];

    // Exibe o lugar sorteado com o ID sequencial
    echo('<div class="tabela-lugares">');
    echo('<table class="tabela">');
    echo('<thead class="tb-thead">');
    echo('<tr>');
    echo('<th scope="col">ID</th>');  // O "ID" sequencial visível para o usuário
    echo('<th scope="col">NOME</th>');
    echo('<th scope="col">LOCAL</th>');
    echo('<th scope="col">OBSERVAÇÃO</th>');
    echo('<th scope="col">PREÇO</th>');
    echo('<th scope="col">NOTA</th>');
    echo('<th scope="col">JÁ FOMOS</th>');
    echo('</tr>');
    echo('</thead>');
    echo('<tbody class="tb-tbody">');
    echo "<tr>";
    echo "<td>".$lugarSorteado['sequencial']."</td>"; // Mostra o ID sequencial para o usuário
    echo "<td>".$lugarSorteado['nome']."</td>";
    echo "<td>".$lugarSorteado['local']."</td>";
    echo "<td>".$lugarSorteado['observacao']."</td>";
    echo "<td>".$lugarSorteado['preco']."</td>";
    echo "<td>".$lugarSorteado['nota']."</td>";
    echo "<td>".$lugarSorteado['jaFomos']."</td>";
    echo "</tr>";
    echo('</tbody>');
    echo('</table>');
    echo('</div>');
} else {
    echo "<div class='erro'><p>Nenhum local encontrado para sortear!</p></div>";

}

$conexao->close();
?>
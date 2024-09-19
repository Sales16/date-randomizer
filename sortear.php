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

$stmt = $conexao->prepare("SELECT * FROM lugares WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultado = $stmt->get_result();

// Cria um array para armazenar os dados dos lugares com seus IDs sequenciais
$lugares = [];
$indice = 1;

while ($row = $resultado->fetch_assoc()) {
    $lugares[] = array_merge($row, ['sequencial' => $indice++]);
}

$stmt->close();

// Verifica se há algum lugar para sortear
if (count($lugares) > 0) {
    $randomIndex = array_rand($lugares);

    $lugarSorteado = $lugares[$randomIndex];

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
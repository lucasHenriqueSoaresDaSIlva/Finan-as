<?php
require_once("conexao.php");
$usuario_id = 1; // Exemplo

// Adiciona transação
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $descricao = $_POST["descricao"];
    $valor = floatval(str_replace(",",".",$_POST["valor"]));
    $tipo = $_POST["tipo"]; // entrada ou saída
    $data = $_POST["data"];
    $vfinal = $tipo == "entrada" ? abs($valor) : -abs($valor);
    $stmt = $pdo->prepare("INSERT INTO despesas (usuario_id, categoria, valor, data) VALUES (?, ?, ?, ?)");
    $stmt->execute([$usuario_id, $descricao, $vfinal, $data]);
    header("Location: despesas.php");
}

// Remove transação
if (isset($_GET["del"])) {
    $id = intval($_GET["del"]);
    $stmt = $pdo->prepare("DELETE FROM despesas WHERE id=? AND usuario_id=?");
    $stmt->execute([$id,$usuario_id]);
    header("Location: despesas.php");
}

// Consulta totais
$stmt = $pdo->prepare("SELECT SUM(valor) as entradas FROM despesas WHERE usuario_id=? AND valor>0");
$stmt->execute([$usuario_id]);
$entradas = $stmt->fetchColumn() ?: 0;
$stmt = $pdo->prepare("SELECT SUM(valor) as saidas FROM despesas WHERE usuario_id=? AND valor<0");
$stmt->execute([$usuario_id]);
$saidas = $stmt->fetchColumn() ?: 0;
$total = $entradas + $saidas;

// Lista de transações
$stmt = $pdo->prepare("SELECT * FROM despesas WHERE usuario_id=? ORDER BY data DESC");
$stmt->execute([$usuario_id]);
$transacoes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Despesas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php include("header.php"); ?>
    <div class="cards-container">
        <div class="card income">
            <div class="card-header">Entradas <i class="fa fa-arrow-up"></i></div>
            <div class="card-value">R$ <?=number_format($entradas,2,",",".")?></div>
        </div>
        <div class="card expense">
            <div class="card-header">Saídas <i class="fa fa-arrow-down"></i></div>
            <div class="card-value">-R$ <?=number_format(abs($saidas),2,",",".")?></div>
        </div>
        <div class="card total">
            <div class="card-header">Total <i class="fa fa-dollar-sign"></i></div>
            <div class="card-value"><?=($total<0?"-":"")?>R$ <?=number_format(abs($total),2,",",".")?></div>
        </div>
    </div>
    <div class="container" style="max-width:1000px;margin:0 auto;">
        <form class="form-inline" method="post" style="margin-top:20px;">
            <button type="button" class="add-transaction-btn" onclick="document.getElementById('form_transacao').style.display='flex'">
                <i class="fa fa-plus"></i> Nova Transação
            </button>
        </form>
        <form id="form_transacao" class="form-inline" method="post" style="display:none;">
            <input type="text" name="descricao" placeholder="Descrição" required>
            <select name="tipo">
                <option value="entrada">Entrada</option>
                <option value="saida">Saída</option>
            </select>
            <input type="number" name="valor" step="0.01" placeholder="Valor" required>
            <input type="date" name="data" required>
            <button type="submit" name="add" class="add-transaction-btn"><i class="fa fa-check"></i> Adicionar</button>
        </form>
        <table class="transactions-table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($transacoes as $t): ?>
                <tr>
                    <td><?=htmlspecialchars($t["categoria"])?></td>
                    <td class="value <?=($t["valor"]>=0?"positive":"negative")?>">
                        <?=($t["valor"]>=0?"R$ ":"-R$ ").number_format(abs($t["valor"]),2,",",".")?>
                    </td>
                    <td><?=date("d/m/Y",strtotime($t["data"]))?></td>
                    <td class="action">
                        <form method="get" style="display:inline;">
                            <input type="hidden" name="del" value="<?=$t["id"]?>">
                            <button type="submit" class="remove-btn" title="Remover"><i class="fa fa-times-circle"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php include("footer.php"); ?>
    <script>
    // Show/hide transaction form
    </script>
</body>
</html>
<?php
// Função para calcular financiamento pelo método Price
function calcularParcelas($valor, $taxa_aa, $prazo) {
    if ($valor <= 0 || $taxa_aa < 0 || $prazo < 1) return null;
    $taxa_am = pow(1 + $taxa_aa / 100, 1/12) - 1;
    $parcela = $valor * ($taxa_am * pow(1 + $taxa_am, $prazo)) / (pow(1 + $taxa_am, $prazo) - 1);
    $saldo = $valor;
    $grafico = [];
    $juros_total = 0;
    for ($i = 1; $i <= $prazo; $i++) {
        $juros = $saldo * $taxa_am;
        $principal = $parcela - $juros;
        $saldo -= $principal;
        $juros_total += $juros;
        $grafico[] = [
            "mes" => "Mês $i",
            "valor" => round(max($saldo, 0), 2)
        ];
    }
    return [
        "parcela" => $parcela,
        "total_pago" => $parcela * $prazo,
        "juros_total" => $juros_total,
        "grafico" => $grafico
    ];
}

// Processa o formulário e valida dados
$result = null;
$form_error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $valor = floatval(str_replace(",", ".", $_POST["valor"] ?? ""));
    $prazo = intval($_POST["prazo"] ?? 0);
    $taxa_aa = floatval(str_replace(",", ".", $_POST["taxa"] ?? ""));
    if ($valor <= 0 || $prazo < 12 || $taxa_aa < 0) {
        $form_error = "Preencha todos os campos corretamente (valor > 0, prazo ≥ 12 meses, taxa ≥ 0).";
    } else {
        $result = calcularParcelas($valor, $taxa_aa, $prazo);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Simulador de Financiamento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="header">
        <a href="index.php" class="logo-link">
            <img src="logo.png" class="logo" alt="Logo Educação Financeira SESI-SENAI" />
        </a>
        <nav class="menu">
            <a href="index.php"><i class="fa fa-home"></i> Home</a>
            <a href="despesas.php"><i class="fa fa-credit-card"></i> Despesas</a>
            <a href="financiamento.php"><i class="fa fa-calculator"></i> Simulador Financiamento</a>
            <a href="investimentos.php"><i class="fa fa-chart-line"></i> Investimentos</a>
            <a href="educacao.php"><i class="fa fa-book"></i> Educação</a>
        </nav>
    </div>
    <div class="simulator-container">
        <h2>Simulador de Financiamento</h2>
        <form class="simulator-form" method="post" autocomplete="off">
            <label for="tipo">Tipo de Financiamento:</label>
            <select name="tipo" id="tipo">
                <option <?=(!isset($_POST["tipo"])||$_POST["tipo"]=="Imobiliário")?'selected':''?>>Imobiliário</option>
                <option <?=(@$_POST["tipo"]=="Veicular")?'selected':''?>>Veicular</option>
                <option <?=(@$_POST["tipo"]=="Pessoal")?'selected':''?>>Pessoal</option>
            </select>
            <label for="valor">Valor Total (R$):</label>
            <input type="number" min="0.01" name="valor" id="valor" step="0.01" value="<?=isset($_POST["valor"])?htmlspecialchars($_POST["valor"]):""?>" required>
            <label for="prazo" class="slider-label">Prazo (Meses):</label>
            <input type="range" name="prazo" id="prazo" min="12" max="120" value="<?=isset($_POST["prazo"])?$_POST["prazo"]:60?>" oninput="prazo_out.value=this.value">
            <output id="prazo_out"><?=isset($_POST["prazo"])?$_POST["prazo"]:60?></output> meses
            <label for="taxa">Taxa de Juros (% a.a.):</label>
            <input type="number" min="0" name="taxa" id="taxa" step="0.01" value="<?=isset($_POST["taxa"])?htmlspecialchars($_POST["taxa"]):"10.00"?>" required>
            <button type="submit"><i class="fa fa-calculator"></i> Calcular</button>
        </form>
        <?php if($form_error): ?>
            <div class="simulation-result" style="color:#b9005d;">
                <strong><?=htmlspecialchars($form_error)?></strong>
            </div>
        <?php elseif($result): ?>
        <div class="simulation-result">
            <h3>Resultados da Simulação</h3>
            <div style="margin-bottom:10px;">
                <span style="font-weight:600;color:#180063;">Tipo:</span>
                <span><?=htmlspecialchars($_POST["tipo"])?></span>
            </div>
            <div>Valor da Parcela: <strong>R$ <?=number_format($result["parcela"],2,",",".")?></strong></div>
            <div>Custo Total do Crédito: <strong>R$ <?=number_format($result["total_pago"],2,",",".")?></strong></div>
            <div>Total de Juros Pagos: <strong>R$ <?=number_format($result["juros_total"],2,",",".")?></strong></div>
            <div class="chart-container" style="margin-top:25px;">
                <canvas id="graficoSaldo" height="160"></canvas>
            </div>
            <script>
            // Gráfico do saldo devedor
            const ctx = document.getElementById('graficoSaldo').getContext('2d');
            const chartData = {
                labels: <?=json_encode(array_map(fn($g)=>$g["mes"],$result["grafico"]))?>,
                datasets: [{
                    label:'Saldo Devedor (R$)',
                    data: <?=json_encode(array_map(fn($g)=>$g["valor"],$result["grafico"]))?>,
                    borderColor: '#180063',
                    backgroundColor: 'rgba(24,0,99,0.07)',
                    fill:true,
                    tension:0.15,
                    pointRadius:2
                }]
            };
            new Chart(ctx, {
                type:'line',
                data: chartData,
                options:{
                    scales:{y:{beginAtZero:false}},
                    plugins:{legend:{display:true}},
                    responsive:true,
                    maintainAspectRatio:false
                }
            });
            </script>
        </div>
        <?php endif; ?>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Educação Financeira SESI-SENAI</title>
    <link rel="stylesheet" href="style.css">
    <!-- FontAwesome para os ícones do menu -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
    <div class="container" style="max-width:800px;margin:0 auto; background: #fff; border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,0.05); padding:40px 25px; margin-top:60px;">
        <h2 style="color:#180063;font-size:2em;font-weight:700;">Bem-vindo à sua plataforma de educação financeira!</h2>
        <p style="color:#222;font-size:1.1em;">"O dinheiro é um excelente servo, mas um péssimo mestre." – Francis Bacon</p>
        <div style="display:flex;gap:30px;justify-content:center;margin-top:40px;">
            <a href="despesas.php" class="card income" style="text-decoration:none;min-width:200px;">
                <div class="card-header">Gerenciador de Despesas <i class="fa fa-credit-card"></i></div>
                <div class="card-value"><i class="fa fa-arrow-right"></i></div>
            </a>
            <a href="financiamento.php" class="card expense" style="text-decoration:none;min-width:200px;">
                <div class="card-header">Simulador Financiamento <i class="fa fa-calculator"></i></div>
                <div class="card-value"><i class="fa fa-arrow-right"></i></div>
            </a>
            <a href="educacao.php" class="card total" style="text-decoration:none;min-width:200px;">
                <div class="card-header">Educação <i class="fa fa-book"></i></div>
                <div class="card-value"><i class="fa fa-arrow-right"></i></div>
            </a>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>
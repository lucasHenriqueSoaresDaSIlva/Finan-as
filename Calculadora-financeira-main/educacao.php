<?php
require_once("conexao.php");

// Conteúdos educativos fixos (mantidos fora do banco para performance e simplicidade)
$conteudos = [
    [
        "titulo" => "O que são Juros Simples e Compostos?",
        "descricao" => "Juros simples são calculados somente sobre o valor inicial investido ou emprestado. Já os juros compostos acumulam sobre o valor inicial e também sobre os juros já gerados ao longo do tempo. Entender a diferença entre eles é essencial para fazer escolhas financeiras inteligentes.",
        "tipo" => "artigo",
        "url" => "https://www.serasa.com.br/creditos/juros-simples-e-compostos/"
    ],
    [
        "titulo" => "Como evitar dívidas e sair do vermelho?",
        "descricao" => "O primeiro passo é mapear todas as despesas e receitas mensais. Em seguida, priorize o pagamento das dívidas com juros maiores e renegocie prazos e valores quando possível. Lembre-se: organização e disciplina são fundamentais para manter a saúde financeira.",
        "tipo" => "artigo",
        "url" => "https://www.dinheiroroot.com.br/blog/como-sair-do-vermelho/"
    ],
    [
        "titulo" => "Educação Financeira: Por que investir?",
        "descricao" => "Investir permite que seu dinheiro trabalhe para você. Com planejamento, é possível alcançar objetivos como comprar um imóvel, realizar viagens ou garantir uma aposentadoria tranquila. Comece pequeno e aumente seus aportes conforme possível.",
        "tipo" => "artigo",
        "url" => "https://www.infomoney.com.br/minhas-financas/educacao-financeira/"
    ],
    [
        "titulo" => "Vídeo: Como funciona o crédito no Brasil",
        "descricao" => "Entenda como os bancos calculam os juros e o que considerar ao tomar crédito.",
        "tipo" => "video",
        "url" => "https://www.youtube.com/embed/3ZzFYS7hVr0"
    ],
    [
        "titulo" => "Dica rápida: Juros abusivos",
        "descricao" => "Fique atento a taxas muito acima das praticadas pelo mercado. Pesquise e compare antes de aceitar qualquer proposta de empréstimo.",
        "tipo" => "artigo",
        "url" => "https://www.serasa.com.br/creditos/juros-abusivos/"
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Educação sobre Dívidas e Juros</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <!-- FontAwesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
    /* Seções de educação: pode mover para style.css se preferir */
    .educa-titulo {color:#180063;text-align:center;font-size:2.1em;font-weight:700;margin-bottom:22px;}
    .educa-sub {font-size:1.18em;color:#222;text-align:center;margin-bottom:30px;}
    .educa-card {background:#fff;box-shadow:0 2px 12px rgba(24,0,99,0.07);border-radius:13px;padding:26px 24px;margin-bottom:28px;}
    .educa-card h4 {color:#180063;margin-top:0;margin-bottom:10px;}
    .educa-card p {color:#23253b;font-size:1.08em;}
    .educa-card iframe {margin-top:10px;border-radius:8px;max-width:100%;}
    .educa-card a {color:#13c193;font-weight:600;text-decoration:none;}
    .educa-card a:hover {text-decoration:underline;}
    @media (max-width:600px) {
        .educa-card {padding:19px 10px;}
        .educa-titulo {font-size:1.4em;}
        .educa-sub {font-size:1em;}
    }
    </style>
</head>
<body>
    <?php include("header.php"); ?>
    <div class="container" style="max-width:900px;margin:30px auto 80px auto;background:#fff;border-radius:13px;box-shadow:0 4px 12px rgba(0,0,0,0.07);padding:32px;">
        <div class="educa-titulo">
            Educação sobre Dívidas, Juros e Investimentos
        </div>
        <div class="educa-sub">
            Aprenda como tomar melhores decisões financeiras e conheça estratégias para investir, lidar com dívidas e entender os juros.
        </div>
        <?php foreach ($conteudos as $c): ?>
            <div class="educa-card">
                <h4><?=htmlspecialchars($c["titulo"])?></h4>
                <p><?=htmlspecialchars($c["descricao"])?></p>
                <?php if ($c["tipo"] == "video"): ?>
                    <iframe width="380" height="213" src="<?=htmlspecialchars($c["url"])?>" frameborder="0" allowfullscreen></iframe>
                <?php else: ?>
                    <a href="<?=htmlspecialchars($c["url"])?>" target="_blank" rel="noopener noreferrer">Saiba mais</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div style="text-align:center;margin-top:22px;color:#888;">
            <i class="fa fa-lightbulb"></i>
            <span>Pratique educação financeira diariamente para conquistar sua liberdade e tranquilidade!</span>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>
<?php
$scriptsToLoad = [];
$scriptsFolder = scandir("scripts");
foreach ($scriptsFolder as $script) {
    if (strpos($script, ".js") !== false) {
        $scriptsToLoad[] = "<script src='scripts/$script'></script>";
    }
}
$scripts = implode("", $scriptsToLoad);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>System Page</title>

    <!-- Pico CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.2.1/css/pico.min.css" />
    <link rel="stylesheet" href="style/bootstrap-grid/css/pico-bootstrap-grid.min.css">
    <link rel="stylesheet" href="style/system_style.css">
    <link rel="stylesheet" href="style/pico-docs/pico.docs.min.css">

    <?= $scripts ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

</head>

<body>
    <!-- Navigation Bar -->
    <nav class="container-fluid">
        <ul>
            <li>
                <a href="index.php" class="navbar-brand">
                    <img src="images/market_stand.png" alt="Logo" style="width: 3rem;margin: 0.3rem;"/>
                </a>
            </li>
        </ul>
    </nav>

    <main class="container-fluid">
        <!-- Sidebar -->
        <aside>
            <details open=true>
                <summary>Vendas</summary>
                <ul>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="SalesView.init();">Vendas</a>
                    </li>
                </ul>
            </details>
            <details open=true>
                <summary>Configuração</summary>
                <ul>
                    <li>
                        <a href="#" class="nav-link" onclick="ProductTypeView.init()">Tipos de Produtos</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" onclick="ProductView.init()">Produtos</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" onclick="ProductPriceView.init()">Preços</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" onclick="ProductTypeTaxView.init()">Impostos</a>
                    </li>
                </ul>
            </details>
        </aside>

        <!-- Main Content -->
        <div role="document" id="viewContent">
        </div>
    </main>
</body>

</html>
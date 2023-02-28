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

    <?= $scripts ?>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar system-navbar">
        <a href="#" class="navbar-brand">Mercado</a>
    </nav>

    <!-- Main Content -->
    <main class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-2 sydebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="loadView('sales/index')">Vendas</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="loadView('productsTypes/index')">Tipos de Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="loadView('products/index')">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="loadView('prices/index')">Preços</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="loadView('taxes/index')">Impostos</a>
                    </li>
                </ul>
            </aside>

            <!-- Main Content -->
            <main class="col-md-9" id="viewContent">

            </main>
        </div>
    </main>
</body>

</html>
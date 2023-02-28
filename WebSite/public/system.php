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
                        <a href="#" class="nav-link">Vendas</a>
                    </li>
                    <li>
                    <a href="#" class="nav-link">Tipos de Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Preços</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Impostos</a>
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
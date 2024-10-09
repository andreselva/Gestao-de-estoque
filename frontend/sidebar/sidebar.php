<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../sidebar/sidebar.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
</head>

<body>

    <aside class="sidebar">

        <header class="sidebar-header">
            <img class="logo-img" src="./../img/avatar.jpg" alt="Foto do usuário">
        </header>

        <nav>
            <button onclick="goToProducts(event)">
                <span>
                    <i class="material-symbols-outlined"> view_object_track </i>
                    <span>Produtos</span>
                </span>
            </button>

            <div>
                <button onclick="toggleStockMenu(event)">
                    <span>
                        <i class="material-symbols-outlined"> inventory_2 </i>
                        <span>Suprimentos</span>
                    </span>
                </button>
                <div class="collapse-menu">
                    <button onclick="goToStock(event)">Estoque</button>
                    <button onclick="goToAnotherOption(event)">Notas de entrada</button>
                </div>
            </div>

            <button>
                <span>
                    <i class="material-symbols-outlined"> settings </i>
                    <span>Settings</span>
                </span>
            </button>
        </nav>


    </aside>

    <script src="./../sidebar/sidebar.js"></script>
</body>

</html>
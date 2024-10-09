<?php
require_once __DIR__ . '../../auth.php';
require_once __DIR__ . '../../sidebar/sidebar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suprimentos</title>
    <link rel="stylesheet" href="../suprimentos/css/nota-entrada.css">
</head>

<body>


    <div id="main-content">
        <main>
            <section id="section-nota">
                <div id="container">
                    <div>
                        <button id="open-modal" class="minimal-button" onclick="goToAddEntryNote(event)">
                            Incluir nota
                        </button>
                    </div>
                    <div>
                        <div id="search-field" class="form-group medium-input">
                            <input type="text" class="minimal-search" id="search-input" placeholder="Pesquisar...">
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>



    <script src="./js/form-nota-entrada-controller.js"></script>
</body>

</html>
<?php
require_once('db_connection.php');
// Дефинирање на дозволени страници
$allowed_pages = [
    'index'  => 'campaigns-index.php',

];

// Добиј ја тековната страница од URL-то, ако нема зададено, прикажи index
$page = isset($_GET['page']) ? $_GET['page'] : 'index';

// Проверка дали страната е дозволена, ако не, прикажи index
if (!array_key_exists($page, $allowed_pages)) {
    $page = 'index';
}
?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaigns Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Навигација -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="campaigns.php?page=index">Kампањи</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="campaigns.php?page=index">Сите кампањи</a></li>

            </ul>
        </div>
    </div>
</nav>

<!-- Главна содржина -->
<div class="container mt-4">
    <?php include $allowed_pages[$page]; ?>
</div>
<div class="text-center mt-4">
        <a href="admin_dashboard.php" class="btn btn-warning">Врати се назад!</a>
    </div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

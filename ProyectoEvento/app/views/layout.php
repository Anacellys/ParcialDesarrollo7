<?php
/**
 * Layout compartido para todas las vistas del proyecto.
 */
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evento Tecnológico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-cpu me-2"></i>ITECH</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-pencil-square me-1"></i>Inscripción</a></li>
                <li class="nav-item"><a class="nav-link" href="reporte.php"><i class="bi bi-bar-chart-line me-1"></i>Reporte</a></li>
                <li class="nav-item"><a class="nav-link" href="exportar_excel.php"><i class="bi bi-file-earmark-excel me-1"></i>Exportar Excel</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-success shadow-sm"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?= $content ?? '' ?>
</main>

<footer class="bg-dark text-white mt-5 py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="fw-bold">© 2025 Anacelis Boniche</h5>
                <p class="mb-0">All Rights Reserved</p>
            </div>
           
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

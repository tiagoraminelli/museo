<?php
session_start(); // Inicia la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./public/css/index.css">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <?php include('./includes/navbar.php') ?>

    <!-- Carrusel Section -->
    <section class="my-5">
        <div class="container">
            <?php include('./includes/carrusel.php') ?>
        </div>
    </section>

    <!-- Presentación Section -->
    <section class="bg-white py-5">
        <div class="container">
            <?php include('./includes/presentacion.php') ?>
        </div>
    </section>

    <!-- Galería Section -->
    <section class="py-5">
        <div class="container">
            <?php include('./includes/galeria.php') ?>
        </div>
    </section>

    <!-- Horarios Section -->
    <section class="bg-gray-100 py-5">
        <div class="container">
            <?php include('./includes/horarios.php') ?>
        </div>
    </section>

    <!-- Equipo Section -->
    <section class="py-5">
        <div class="container">
            <?php include('./includes/equipo.php') ?>
        </div>
    </section>

    <!-- Ubicación Section -->
    <section class="bg-white py-5">
        <div class="container">
            <?php include('./includes/ubicacion.php') ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include('./includes/footer.php') ?>

</body>
 <!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>

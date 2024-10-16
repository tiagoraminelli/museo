<?php //include('./assets/carrusel.php') ?>
<div id="carouselExampleIndicators" class="carousel slide relative" data-ride="carousel">
  <!-- Indicadores del carrusel -->
  <ol class="carousel-indicators absolute bottom-0 left-0 right-0 flex justify-center p-0 mb-4">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active bg-white rounded-full w-3 h-3 mx-1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1" class="bg-gray-300 rounded-full w-3 h-3 mx-1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2" class="bg-gray-300 rounded-full w-3 h-3 mx-1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3" class="bg-gray-300 rounded-full w-3 h-3 mx-1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="4" class="bg-gray-300 rounded-full w-3 h-3 mx-1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="5" class="bg-gray-300 rounded-full w-3 h-3 mx-1"></li>
  </ol>

  <!-- Imágenes del carrusel -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./assets/img/carrusel 6.jpg" class="d-block w-full h-96 object-cover" alt="Placeholder 1">
    </div>
    <div class="carousel-item">
      <img src="./assets/img/carrusel.jpg" class="d-block w-full h-96 object-cover" alt="Placeholder 2">
    </div>
    <div class="carousel-item">
      <img src="./assets/img/carrusel 2.jpg" class="d-block w-full h-96 object-cover" alt="Placeholder 3">
    </div>
    <div class="carousel-item">
      <img src="./assets/img/carrusel 3.jpg" class="d-block w-full h-96 object-cover" alt="Placeholder 4">
    </div>
    <div class="carousel-item">
      <img src="./assets/img/carrusel 4.jpg" class="d-block w-full h-96 object-cover" alt="Placeholder 5">
    </div>
    <div class="carousel-item">
      <img src="./assets/img/carrusel 5.jpg" class="d-block w-full h-96 object-cover" alt="Placeholder 6">
    </div>
  </div>

  <!-- Controles del carrusel -->
  <a class="carousel-control-prev absolute top-0 bottom-0 left-0 flex items-center justify-center p-4 text-gray-700 hover:text-gray-900" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon bg-dark rounded-full p-2" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next absolute top-0 bottom-0 right-0 flex items-center justify-center p-4 text-gray-700 hover:text-gray-900" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon bg-dark rounded-full p-2" aria-hidden="true"></span>
    <span class="sr-only">Siguiente</span>
  </a>
</div>

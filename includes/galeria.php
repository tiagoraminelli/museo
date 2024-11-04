<?php
require_once "./modelo/bd.php"; // Asegúrate de que este archivo contenga la clase Db
require_once "./modelo/pieza.php"; // Asegúrate de que este archivo contenga la clase Db

// Conexión a la base de datos
$pieza = new Pieza();
$piezas = $pieza->getAllPiezas();
?>

<div class="container mt-5">
    <h2 class="text-3xl font-bold text-center mb-5">Galería de Imágenes</h2>
    <div class="overflow-hidden relative">
        <div id="gallery" class="flex transition-transform duration-500 ease-in-out">
            <?php if (!empty($piezas)): ?>
                <?php foreach ($piezas as $pieza): ?>
                    <div class="min-w-full flex flex-col items-center"> <!-- Flex y centrar -->
                        <img src="./assets/uploads/<?php echo $pieza['imagen']; ?>" 
                             alt="<?php echo $pieza['especie']; ?>" 
                             class="img-fluid hover-effect object-cover w-full h-68"> <!-- Mantener proporciones -->
                        <div class="image-description mt-2">
                            <p><?php echo $pieza['observacion']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="min-w-full flex flex-col items-center">
                    <img src="https://via.placeholder.com/300" alt="No hay imágenes" class="img-fluid hover-effect object-cover w-full h-64"> <!-- Mantener proporciones -->
                    <div class="image-description mt-2">
                        <p>No hay imágenes disponibles en este momento.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    const gallery = document.getElementById('gallery');
    let currentIndex = 0;

    function updateGallery() {
        const totalImages = gallery.children.length;
        const offset = -currentIndex * 100;
        gallery.style.transform = `translateX(${offset}%)`;
    }

    function autoSlide() {
        const totalImages = gallery.children.length;
        currentIndex = (currentIndex + 1) % totalImages;
        updateGallery();
    }

    if (gallery.children.length > 0) {
        setInterval(autoSlide, 3000); // Cambia cada 3 segundos
    }
</script>

<div class="container mt-5">
    <h2 class="text-3xl font-bold text-center mb-5">Galería de Imágenes</h2>
    <div class="overflow-hidden relative">
        <div id="gallery" class="flex transition-transform duration-500 ease-in-out">
            <div class="min-w-full flex flex-col items-center"> <!-- Flex y centrar -->
                <img src="https://via.placeholder.com/300" alt="Imagen 1" class="img-fluid hover-effect">
                <div class="image-description mt-2">
                    <p>Esta es una descripción larga de la imagen 1. Aquí se puede incluir información interesante sobre la pieza o el objeto que se está mostrando.</p>
                </div>
            </div>
            <div class="min-w-full flex flex-col items-center"> <!-- Flex y centrar -->
                <img src="https://via.placeholder.com/300" alt="Imagen 2" class="img-fluid hover-effect">
                <div class="image-description mt-2">
                    <p>Esta es una descripción larga de la imagen 2. Aquí se puede incluir información interesante sobre la pieza o el objeto que se está mostrando.</p>
                </div>
            </div>
            <div class="min-w-full flex flex-col items-center"> <!-- Flex y centrar -->
                <img src="https://via.placeholder.com/300" alt="Imagen 3" class="img-fluid hover-effect">
                <div class="image-description mt-2">
                    <p>Esta es una descripción larga de la imagen 3. Aquí se puede incluir información interesante sobre la pieza o el objeto que se está mostrando.</p>
                </div>
            </div>
            <div class="min-w-full flex flex-col items-center"> <!-- Flex y centrar -->
                <img src="https://via.placeholder.com/300" alt="Imagen 4" class="img-fluid hover-effect">
                <div class="image-description mt-2">
                    <p>Esta es una descripción larga de la imagen 4. Aquí se puede incluir información interesante sobre la pieza o el objeto que se está mostrando.</p>
                </div>
            </div>
            <div class="min-w-full flex flex-col items-center"> <!-- Flex y centrar -->
                <img src="https://via.placeholder.com/300" alt="Imagen 5" class="img-fluid hover-effect">
                <div class="image-description mt-2">
                    <p>Esta es una descripción larga de la imagen 5. Aquí se puede incluir información interesante sobre la pieza o el objeto que se está mostrando.</p>
                </div>
            </div>
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

    setInterval(autoSlide, 3000); // Cambia cada 3 segundos
</script>

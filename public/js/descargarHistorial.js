
    $(document).ready(function() {
        $('#descargarHistorial').click(function() {
            $.ajax({
                url: './funciones/descargarHistorial.php', // Cambia esto a la ruta correcta
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.file) {
                        // Crea un enlace temporal para descargar el archivo
                        var a = document.createElement('a');
                        a.href = response.file;
                        a.download = 'historial.txt';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    } else {
                        alert('Error al descargar el archivo.');
                    }
                },
                error: function() {
                    alert('Error en la solicitud.');
                }
            });
        });
    });

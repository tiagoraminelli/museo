
    $(document).ready(function () {
        $('#clasificacion').change(function () {
            const selectedValue = $(this).val();
            $('.hidden').hide(); // Oculta todos los campos adicionales
            if (selectedValue === "Paleontología") {
                $('#paleontologiaFields').show();
            } else if (selectedValue === "Osteología") {
                $('#osteologiaFields').show();
            } else if (selectedValue === "Ictiología") {
                $('#ictiologiaFields').show();
            } else if (selectedValue === "Geología") {
                $('#geologiaFields').show();
            } else if (selectedValue === "Botánica") {
                $('#botanicaFields').show();
            } else if (selectedValue === "Zoología") {
                $('#zoologiaFields').show();
            } else if (selectedValue === "Arqueología") {
                $('#arqueologiaFields').show();
            } else if (selectedValue === "Octología") {
                $('#octologiaFields').show();
            }
        });

        $('#addDonante').click(function () {
            $('#donanteForm').toggleClass('hidden');
        });

    
    });

$(document).ready(function () {
    aggiornaInterfaccia();
});

$(document).on('login', function () {
    aggiornaInterfaccia();
});


function aggiornaInterfaccia() {
    // Effettua la richiesta AJAX al server per recuperare le informazioni sull'utente
    $.ajax({
        type: 'GET',
        url: 'getUserRole.php',
        dataType: 'json',
        success: function (data) {
            // Analizza la risposta JSON e nasconde o mostra gli elementi sulla pagina web in base al ruolo dell'utente
            if (data.role == 'admin') {
                $('.admin').show();
                //$('.operatore').hide();
            } else if (data.role == 'operatore_negozio') {
                $('.admin').hide();
                $('.operatore_magazzino').hide();
                $('.operatore_negozio').show();
            } else if (data.role == 'operatore_magazzino') {
                $('.admin').hide();
                $('.operatore_magazzino').show();
                $('.operatore_negozio').hide();
            } else {
                $('.admin').hide();
                $('.operatore_negozio').hide();
                ('.operatore_magazzino').hide();
            }

        }
    });
}
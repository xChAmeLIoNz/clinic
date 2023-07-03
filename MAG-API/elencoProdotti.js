//TABELLA PRODOTTI MAG E NEG

$(document).ready(function () {

    var tableProd = $('#prodottiModifica').DataTable({
        "language": {
            "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/it-IT.json',
        },
        "ajax": {
            "url": "getData.php",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id", "title": "#" },
            { "data": "name", "title": "Nome" },
            { "data": "price", "title": "Prezzo" },
            { "data": "sku", "title": "EAN" },
            { "data": "stock_quantity", "title": "Negozio", "name": "negozio" },
            { "data": "stock_quantity_2", "title": "Magazzino", "name": "magazzino" },
            {
                "data": null,
                "title": "Modifica",
                "defaultContent": "<button class='btn edit-btn admin'><i class='bi bi-pencil'></i></button>",
                "visible": true
            }
        ],
        "initComplete": function (settings, json) {
            $('#prodottiModifica_filter input').focus();
        }

    });



    /*$('div.dataTables_filter input').focus();
    $('#prodottiModifica_filter input').on('keypress', (e) => {
        console.log("keypress");
        if (e.key == 13) {
            console.log('enter pressed');
            $('div.dataTables_filter input').select();
        }
    });*/
    /*
        var activeButton = sessionStorage.getItem('activeButton');
        if (activeButton) {
            $('#' + activeButton).addClass('active');
            sessionStorage.clear();
        }
    
        if ($('#btnNegozio').hasClass('active')) {
            tableProd.column(5).visible(false);
            tableProd.column(4).visible(true);
            $('div.dataTables_filter input').focus();
        } else if ($('#btnMagazzino').hasClass('active')) {
            tableProd.column(5).visible(true);
            tableProd.column(4).visible(false);
            $('div.dataTables_filter input').focus();
        } else if ($('#btnEntrambi').hasClass('active')) {
            tableProd.column(5).visible(true);
            tableProd.column(4).visible(true);
            $('div.dataTables_filter input').focus();
        }
    
        // gestione evento click sul bottone magazzino 1
        $('#btnNegozio').on('click', function () {
            // Store the ID of the active button in sessionStorage
            sessionStorage.setItem('activeButton', 'btnNegozio');
    
            // Rimuovi la classe "active" da tutti i pulsanti
            $('.btn-group > .btn').removeClass('active');
    
            // Aggiungi la classe "active" al pulsante
            $(this).addClass('active');
    
            tableProd.column(5).visible(false);
            tableProd.column(4).visible(true);
            $('div.dataTables_filter input').focus();
        });
    
        $('#btnMagazzino').on('click', function () {
            // Store the ID of the active button in sessionStorage
            sessionStorage.setItem('activeButton', 'btnMagazzino');
    
            // Rimuovi la classe "active" da tutti i pulsanti
            $('.btn-group > .btn').removeClass('active');
    
            // Aggiungi la classe "active" al pulsante
            $(this).addClass('active');
    
            tableProd.column(4).visible(false);
            tableProd.column(5).visible(true);
            $('div.dataTables_filter input').focus();
        });
    
        $('#btnEntrambi').on('click', function () {
            // Store the ID of the active button in sessionStorage
            sessionStorage.setItem('activeButton', 'btnEntrambi');
    
            // Rimuovi la classe "active" da tutti i pulsanti
            $('.btn-group > .btn').removeClass('active');
    
            // Aggiungi la classe "active" al pulsante
            $(this).addClass('active');
    
            tableProd.column(4).visible(true);
            tableProd.column(5).visible(true);
            $('div.dataTables_filter input').focus();
        });
    
        /* add event listener for button to filter by magazzino 2
        $('#magazzino2Btn').click(function () {
            $('#prodottiModifica').DataTable().ajax.url("getData.php?magazzino=2").load();
        });
        */

    /*
        function checkColumns(currentRow) {
            var result = {};
    
            if (tableProd.column('negozio:name').visible() && !(tableProd.column('magazzino:name').visible())) {
                result.visibilita = "negozio";
                result.stock_quantity = currentRow.find('td:eq(4)').text();
                //nascondo le colonne che non servono
                $('#editModal').find('label[for="stock_quantity_2"]').hide();
                $('#editModal').find('#stock_quantity_2').hide();
                $('#editModal').find('label[for="stock_quantity"]').show();
                $('#editModal').find('#stock_quantity').show();
                return result;
            }
    
            if (tableProd.column('magazzino:name').visible() && !(tableProd.column('negozio:name').visible())) {
                result.visibilita = "magazzino";
                //var stock_quantity_2 = currentRow.find('td:eq(5)').text();
                result.stock_quantity_2 = currentRow.find('td:eq(4)').text();
                //nascondo le colonne che non servono
                $('#editModal').find('label[for="stock_quantity"]').hide();
                $('#editModal').find('#stock_quantity').hide();
                $('#editModal').find('label[for="stock_quantity_2"]').show();
                $('#editModal').find('#stock_quantity_2').show();
                return result;
            }
    
            if (tableProd.column('magazzino:name').visible() && tableProd.column('negozio:name').visible()) {
                result.visibilita = "entrambi";
                //var stock_quantity_2 = currentRow.find('td:eq(5)').text();
                result.stock_quantity = currentRow.find('td:eq(4)').text();
                //mag e negozio sono visibili, mostro tutto
                result.stock_quantity_2 = currentRow.find('td:eq(5)').text();
                $('#editModal').find('label[for="stock_quantity"]').show();
                $('#editModal').find('#stock_quantity').show();
                $('#editModal').find('label[for="stock_quantity_2"]').show();
                $('#editModal').find('#stock_quantity_2').show();
                return result;
            }
    
        }
    */

    var originalData = {};

    // Funzione per controllare lo stato dei valori stock_quantity
    function checkStockQuantity() {
        var stock_quantity = $('#stock_quantity').val();
        var original_stock_quantity = originalData.stock_quantity;
        var stock_quantity_2 = $('#stock_quantity_2').val();
        var original_stock_quantity_2 = originalData.stock_quantity_2;

        if (stock_quantity_2 === original_stock_quantity_2 && stock_quantity === original_stock_quantity) {
            $('#saveBtn').prop('disabled', true);
        } else {
            $('#saveBtn').prop('disabled', false);
        }
    }

    $('#prodottiModifica').on('click', '.edit-btn', function () {

        // Get the data from the current row
        var currentRow = $(this).closest('tr');
        var id = currentRow.find('td:eq(0)').text();
        var name = currentRow.find('td:eq(1)').text();
        var price = currentRow.find('td:eq(2)').text();
        var sku = currentRow.find('td:eq(3)').text();
        var stock_quantity = currentRow.find('td:eq(4)').text();
        var stock_quantity_2 = currentRow.find('td:eq(5)').text();

        // Set the data in the modal
        $('#editModal').find('#id').val(id);
        $('#editModal').find('#name').val(name);
        $('#editModal').find('#price').val(price);
        $('#editModal').find('#sku').val(sku);
        $('#editModal').find('#stock_quantity').val(stock_quantity);
        $('#editModal').find('#stock_quantity_2').val(stock_quantity_2);

        //$('#editModal').find('label[for="stock_quantity_2"]').hide();
        //$('#editModal').find('#stock_quantity_2').hide();


        originalData.id = id;
        originalData.name = name;
        originalData.price = price;
        originalData.sku = sku;
        originalData.stock_quantity = stock_quantity;
        originalData.stock_quantity_2 = stock_quantity_2;

        checkStockQuantity();

        // Show the modal
        $('#editModal').modal('show');
    });

    $('#stock_quantity_2, #stock_quantity').on('input', function () {
        // Chiamata alla funzione per controllare lo stato dei valori stock_quantity
        checkStockQuantity();
    });

    $('#saveBtn').click(function (e) {

        //VALORI MODIFICATI NEL MODAL FORM
        var id = $('#id').val();
        var name = $('#name').val();
        var price = $('#price').val();
        var sku = $('#sku').val();
        var stock_quantity = $('#stock_quantity').val();
        var stock_quantity_2 = $('#stock_quantity_2').val();

        var stock_status = (stock_quantity <= 0) ? 'outofstock' : 'instock';

        //VALORI ORIGINALI DEL FORM
        var od_id = originalData.id;
        var od_name = originalData.name;
        var od_price = originalData.price;
        var od_sku = originalData.sku;
        var od_stock_quantity = originalData.stock_quantity;
        var od_stock_quantity_2 = originalData.stock_quantity_2;

        // create data object for API request
        var data = {
            name: name,
            price: price,
            regular_price: price,
            sku: sku,
            stock_quantity: stock_quantity,
            stock_quantity_2: stock_quantity_2,
            stock_status: stock_status
        };

        //send the data to the php page and API
        $.ajax({
            url: 'modificaProdotto.php',
            type: 'POST',
            data: {
                //updated data
                id: id,
                name: name,
                price: price,
                sku: sku,
                stock_quantity: stock_quantity,
                stock_quantity_2: stock_quantity_2,
                //original data
                od_id: od_id,
                od_name: od_name,
                od_price: od_price,
                od_sku: od_sku,
                od_stock_quantity: od_stock_quantity,
                od_stock_quantity_2: od_stock_quantity_2
            },
            success: function (response) {
                //hide modal
                $('#editForm').modal('hide');

                //reload table after update
                $('#prodottiModifica').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });




});



//TABELLA PRODOTTI NEGOZIO
$(document).ready(function () {

    var tableProd = $('#prodottiMagazzino').DataTable({
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
            { "data": "stock_quantity_2", "title": "Magazzino", "name": "magazzino" },
            {
                "data": null,
                "title": "Modifica",
                "defaultContent": "<button class='btn edit-btn'><i class='bi bi-pencil'></i></button>",
                "visible": true
            }
        ],
        "initComplete": function (settings, json) {
            $('#prodottiMagazzino_filter input').focus();
        }

    });


    $('div.dataTables_filter input').focus();


    var originalData = {};

    // Funzione per controllare lo stato dei valori stock_quantity
    function checkStockQuantity() {
        var stock_quantity_2 = $('#stock_quantity_2').val();
        var original_stock_quantity_2 = originalData.stock_quantity_2;

        if (stock_quantity_2 === original_stock_quantity_2) {
            $('#saveBtn').prop('disabled', true);
        } else {
            $('#saveBtn').prop('disabled', false);
        }
    }

    $('#prodottiMagazzino').on('click', '.edit-btn', function () {
        // Get the data from the current row
        currentRow = $(this).closest('tr');
        var id = currentRow.find('td:eq(0)').text();
        var name = currentRow.find('td:eq(1)').text();
        var price = currentRow.find('td:eq(2)').text();
        var sku = currentRow.find('td:eq(3)').text();
        var stock_quantity_2 = currentRow.find('td:eq(4)').text();


        // Set the data in the modal
        $('#editModal').find('#id').val(id);
        $('#editModal').find('#name').val(name);
        $('#editModal').find('#price').val(price);
        $('#editModal').find('#sku').val(sku);
        $('#editModal').find('#stock_quantity_2').val(stock_quantity_2);



        originalData.id = id;
        originalData.name = name;
        originalData.price = price;
        originalData.sku = sku;
        originalData.stock_quantity_2 = stock_quantity_2;

        // Chiamata iniziale per controllare lo stato dei valori stock_quantity
        checkStockQuantity();

        // Show the modal
        $('#editModal').modal('show');
    });

    // Aggiungi un gestore di eventi per il campo stock_quantity
    $('#stock_quantity_2').on('input', function () {
        // Chiamata alla funzione per controllare lo stato dei valori stock_quantity
        checkStockQuantity();
    });

    $('#editModal').on('shown.bs.modal', function () {
        $('#stock_quantity_2').select();
    });


    $('#saveBtn').click(function (e) {

        //VALORI MODIFICATI NEL MODAL FORM
        var id = $('#id').val();
        var name = $('#name').val();
        var price = $('#price').val();
        var sku = $('#sku').val();
        var stock_quantity_2 = $('#stock_quantity_2').val();
        console.log(stock_quantity_2);


        var stock_status = (stock_quantity_2 <= 0) ? 'outofstock' : 'instock';

        //VALORI ORIGINALI DEL FORM
        var od_id = originalData.id;
        var od_name = originalData.name;
        var od_price = originalData.price;
        var od_sku = originalData.sku;
        var od_stock_quantity_2 = originalData.stock_quantity_2;

        // create data object for API request
        var data = {
            name: name,
            price: price,
            regular_price: price,
            sku: sku,
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
                stock_quantity_2: stock_quantity_2,
                //original data
                od_id: od_id,
                od_name: od_name,
                od_price: od_price,
                od_sku: od_sku,
                od_stock_quantity_2: od_stock_quantity_2,
            },
            success: function (response) {      
                        //hide modal
                        $('#editForm').modal('hide');

                        //reload table after update
                        $('#prodottiMagazzino').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


});


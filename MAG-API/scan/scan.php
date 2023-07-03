<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

</head>

<?php
include('config.php');
?>
<div style="display: inline-block; margin-right: 50px">
    <form action="" method="" id="salvaresult">

        <input type="text" placeholder="SKU" id="sku" name="sku" style="max-width:400px" required autofocus onkeypress="return validate(event);" /><br>
        <!-- <input type="number" placeholder="Quantità Negozio" id="" style="max-width:400px" readonly /><br>
        <input type="number" placeholder="Quantità Magazzino" id="" style="max-width:400px" readonly /><br>
        -->
        <input type="number" placeholder="Aggiungi Negozio" id="qty_add" style="max-width:400px" /><br>
        <input type="number" placeholder="Aggiungi Magazzino" id="qty_add_mag" style="max-width:400px" /><br>
        <input type="submit" value="Salva" id="salvadat" />
        <input type="button" value="Ripristina" name="resetcart" id="resetcart" onClick="resetnput();" />
        <input type="button" value="Sincronizza" id="sync" onClick="refreshpage();" />
    </form>
</div>

<div style="display: inline-block;" id="info_prod">
    <div style="text-align: center;">
        <h3 style="font-weight: bold;">Info Prodotto</h3>
        <p>SKU</p>
        <input id="info_sku" style="max-width:400px" readonly /><br>
        <p>NOME</p>
        <input id="info_name" style="max-width:400px" readonly /><br>
        <p>PREZZO</p>
        <input id="info_price" style="max-width:400px" readonly /><br>
        <p id="info_qty_neg">QUANTITA NEGOZIO</p>
        <input id="qty" style="max-width:400px" readonly /><br>
        <p id="info_qty_mag">QUANTITA MAGAZZINO</p>
        <input id="qty_mag" style="max-width:400px" readonly /><br>
        <label for="posizione" id="posizione"></label><br>
    </div>
</div>
<br>
<?php $strnumprod = numprodotti($conn);
echo '<div id="numprod">' . $strnumprod . '</div>';


function numprodotti($conn)
{
    $notice = '';
    if ($conn->connect_error) {

        $connect = false;
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql0 = "SELECT count(sku) as sku from export;";


        $result = mysqli_query($conn, $sql0);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $nbrresult = $row['sku'];
        //$nbrresult=count($row);
        $strss = 'articoli nel carrello';
        if ($nbrresult == 1) {
            $strss = 'articolo nel carrello';
        }
        if ($nbrresult == '') {
            $nbrresult = 0;
        }

        $url = '<a href="cart.php"> --> Apri</a>';
        $notice = '  ' . $nbrresult . '  ' . $strss . ' ' . $url;
    }
    return $notice;
}

?>
<script>
    $(document).ready(() => {
        $('#info_prod').hide();
    });
    const input = document.getElementById("sku");
    input.addEventListener('focusout', updateValue);

    $('#salvadat').on('click', addToCart);

    function updateValue(e) {
        var skuText = e.target.value;
        if (skuText != '') {

            const arr = [skuText];

            const jsonString = JSON.stringify(arr);

            console.log("jsonStrin=:" + jsonString);


            $.ajax({
                url: 'getProd.php',
                type: 'post',
                data: {
                    skuText: jsonString
                },
                success: function(response) {
                    console.log(response);
                    const obj = JSON.parse(response);
                    console.log(obj);
                    var sku = obj.sku;
                    var qty = obj.qty;
                    var qty_mag = obj.qty_mag;
                    var name = obj.name;
                    var price = obj.price;
                    if (sku == '') {
                        alert("Codice non presente");
                        document.getElementById('sku').value = '';
                        resetnput();
                    } else {
                        document.getElementById('sku').value = skuText;
                        //console.log(qty);
                        $('#qty').val(qty);
                        $('#qty_mag').val(qty_mag);
                        //$('#posizione').text('Il prodotto è presente in: ' + obj.pos);
                        $('#info_sku').val(skuText);
                        $('#info_name').val(name);
                        $('#info_price').val(price);
                        if (obj.pos == 'export') {
                            $('#posizione').text('Il prodotto è già presente nel carrello e verrà aggiornato');
                            $('#info_qty_neg').text('CARRELLO NEGOZIO');
                            $('#info_qty_mag').text('CARRELLO MAGAZZINO');
                        } else if (obj.pos == 'products') {
                            $('#posizione').text('Il prodotto non esiste nel carrello e verrà inserito');
                            $('#info_qty_neg').text('QTY NEGOZIO');
                            $('#info_qty_mag').text('QTY MAGAZZINO');
                        }
                        $('#info_prod').show();
                    }


                }
            });
        }



    }

    function validate(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    function addToCart(e) {
        e.preventDefault();
        let sku = $('#sku').val();
        let qty = $('#qty_add').val();
        let qty_mag = $('#qty_add_mag').val();
        //console.log(qty + "da aggiun");
        if (sku != '') {
            if (qty > 0 || qty_mag > 0) {
                const data = [sku, qty, qty_mag];
                const json = JSON.stringify(data);
                console.log(json);

                $.ajax({
                    url: 'addCart.php',
                    type: 'post',
                    data: {
                        data: json
                    },
                    success: (response) => {
                        console.log(response);
                        const obj = JSON.parse(response);
                        let status = obj.response;
                        if (status == 'update') {
                            resetnput();
                            $('#posizione').text("Il prodotto nel carrello è stato aggiornato");
                        } else if (status == 'insert') {
                            resetnput();
                            $('#posizione').text("Il prodotto è stato aggiunto nel carrello");
                        } else {
                            resetnput();
                            $('#posizione').text("Qualcosa è andato storto");
                        }
                        refreshpage();
                    }
                });
            } else {
                alert("Qty non può essere vuoto per entrambi");
            }

        } else {
            alert("SKU o Qty non deve essere vuoto");
            resetnput();
        }

    }

    function resetnput() {
        document.getElementById('sku').value = '';
        $('#qty').val('');
        $('#qty_mag').val('');
        $('#posizione').text('');
        $('#qty_add').val('');
        $('#qty_add_mag').val('');
        $('#info_sku').val('');
        $('#info_name').val('');
        $('#info_price').val('');
        $('#info_prod').hide();
        document.getElementById("sku").focus();

    }

    function refreshpage() {
        window.location.href = 'scan.php';
        document.getElementById("sku").focus();

    }
</script>
<?php
/*
if (isset($_GET['salvacart'])) {

    $sku = $_GET['result'];
    
    $cart = $_COOKIE['user'];

    if ($sku != '' && $sku != '0000000000000') {
        
        $sql = "SELECT * FROM export WHERE sku=$sku;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            //il prodotto è gia stato inserito nel cart
            $row = $result->fetch_array();
            $qty = $row['qty'];
            $sql = "UPDATE export SET qty=$qty+1 WHERE sku=$sku;";
            if ($conn->query($sql)) {
                echo "carrello aggiornato";
            } else {
                echo "operazione update non riuscita";
            }


        } else {
            //il prodotto non è nel cart
            $sql = "SELECT * FROM products WHERE sku=$sku;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                //esiste nella tabella products
                $row = $result->fetch_array();
                $id = $row['id'];
                $name = $row['name'];
                $price = $row['price'];
                $sku = $row['sku'];
                $qty = 1;

                $sql = "INSERT INTO export VALUES (DEFAULT, '$id', '$name', '$price', '$sku', '$qty');";
                if ($conn->query($sql)) {
                    echo "inserimento nel cart avvenuto";
                } else {
                    echo "insert non avvenuto: " . $conn->error;
                }

            } else {
                echo "il prodotto non esiste nella tabella products";
            }
        }
    }
}
*/
?>
<?php
//require_once('protect-this.php');
include('config.php');
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />

<title>Giocat</title>
<link rel="stylesheet" type="text/css" href="https://scan.giocat.it/styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://scan.giocat.it/styles/style.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
<!--<link rel="manifest" href="_manifest.json">-->
<link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
<style>
    a.current{
        filter: brightness(0.20)!important;
    }
        div#numprod{
    color: #0f5132!important;
    background-color: #d1e7dd!important;
    border-color: #badbcc!important;
    font-size: 18px!important;
    max-width: 400px!important;
    padding: 10px!important;
    display: flex!important;
    flex-wrap: nowrap!important;
    align-items: center!important;}
</style>
<!----------------------------------------------------------------------->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Scannerizza</title>
	
	<!-- Styles -->

<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	
<link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://unpkg.com/normalize.css@8.0.0/normalize.css">
 <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null"
    href="https://unpkg.com/milligram@1.3.0/dist/milligram.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!-- Javscript -->
	<script>
	
		if ("serviceWorker" in navigator) {
			window.addEventListener("load", () => {
				navigator.serviceWorker && navigator.serviceWorker.register("./sw.js");
			});
		}

	</script>
<!--	<script defer src="./main.js"></script>-->
	<script src="js/html5-qrcode.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
<!------------------------------------------------------------------->
</head>
<!-- onload="refreshpage() --> 
<body class="theme-light" data-highlight="highlight-red">

<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>

<div id="page">

    <div class="header header-auto-show header-fixed header-logo-center">
        <a href="https://scan.giocat.it/scan.php" class="header-title">Giocat</a>
        <a href="#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-4 show-on-theme-dark"><i class="fas fa-sun"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-4 show-on-theme-light"><i class="fas fa-moon"></i></a>
        <a href="#" data-menu="menu-share" class="header-icon header-icon-3"><i class="fas fa-share-alt"></i></a>
    </div>


<div id="footer-bar" class="footer-bar-6">
<a href="https://scan.giocat.it/index.php"><img src="icon/menu_home.png" /><span><strong>Home</strong></span></a>
<!--<a href="import.php"><img src="icon/menu_import.png"/><span>Importa</span></a>-->
<a href="https://scan.giocat.it/cart.php"><img src="icon/menu_export.png"/><span>Esporta</span></a>
<a class="current" href="https://scan.giocat.it/scan.php"><img src="icon/menu_leggi.png" /><span><strong>Leggi</strong></span></a>
<a href="#" data-menu="menu-main"><img src="icon/menu.png"/><span>Menu</span></a>   </div>
 <!--     <div id="footer-bar" class="footer-bar-6">
        <a href="import.php"><i class="fa fa-layer-group"></i><span>Importa</span></a>
        <a href="export.php"><i class="fa fa-file"></i><span>Esporta</span></a>
        <a href="index.php" class="circle-nav active-nav"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="cart_scan.php"><i class="fa fa-image"></i><span>Carrello</span></a>
        <a href="#" data-menu="menu-main"><i class="fa fa-bars"></i><span>Menu</span></a>
    </div>-->

    <div class="page-title page-title-fixed">
        <h1>Giocat</h1>
        <a href="#" class="page-title-icon shadow-xl bg-theme color-theme" data-menu="menu-share"><i class="fa fa-share-alt"></i></a>
        <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-light" data-toggle-theme><i class="fa fa-moon"></i></a>
        <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-dark" data-toggle-theme><i class="fa fa-lightbulb color-yellow-dark"></i></a>
        <a href="#" class="page-title-icon shadow-xl bg-theme color-theme" data-menu="menu-main"><i class="fa fa-bars"></i></a>
    </div>
    <div class="page-title-clear"></div>

    <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-width="280" data-menu-active="nav-welcome" data-menu-load="menu-main.html"></div>
    <div id="menu-share" class="menu menu-box-bottom rounded-m"  data-menu-load="menu-share.html" data-menu-height="370"> </div>
    <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html" data-menu-height="480"></div>


    <div class="page-content">

       
            


        <div class="card card-style shadow-xl">
            <div class="content">
<script>
    function refreshpage(){
 //   location.reload();
   window.location.href = 'https://scan.giocat.it/scan.php';
    document.getElementById("result").focus();
//
}


</script>
<input type="button" value="" name="ricaricapagina" id="ricaricapagina" onClick="refreshpage()"/>
  
<?php $strnumprod= numprodotti($conn,$_COOKIE['user']);
echo '<div id="numprod">'.$strnumprod.'</div>';


function numprodotti($conn,$cart){
    $notice='';
   	if ($conn->connect_error) {
   	    
			$connect=false;
		  die("Connection failed: " . $conn->connect_error);
	}else{
	    
	     $sql0 = "SELECT count(barcode)as nbr from  export where cart='".$cart."' ";
	     
	     
	      $result = mysqli_query($conn, $sql0);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $nbrresult=$row['nbr'];
            //$nbrresult=count($row);
            $strss='articoli letti';
            if($nbrresult==1){
               $strss='articolo letto';
            }
            if($nbrresult==''){$nbrresult=0;}
            
        $url= '<a href="https://scan.giocat.it/cart_scan.php?idcart='.$_COOKIE['user'].'&caricacart=Carica"> --> Apri</a>';
            $notice='  ' .$nbrresult.'  '.$strss.' '.$url;
         

	}
	return $notice;
}

 ?>
                <h1 class="font-24 font-700 mb-2">Inquadra il codice a barre  <i class="fa fa-star mt-n2 font-30 color-yellow-dark float-end me-2 scale-box"></i></h1>
<!--------------------------------------------------------------------------->
<!--<div class="row"><div class="col"><div  id="reader"></div></div><div class="col" style="padding:30px;"><div id="errore"></div></div></div>-->

<style>
.alert-success {
    color: #0f5132!important;
    background-color: #d1e7dd!important;
    border-color: #badbcc!important;
       font-size: 18px!important;
       max-width: 400px!important;
       padding: 10px!important;
       display: flex!important;
    flex-wrap: nowrap!important;
    align-items: center!important;
}
div#numprod {
    padding-left: 7px!important;
}
    input[type="button"] {
  -webkit-appearance: button;
  cursor: pointer;

}
.alert strong {
    padding-left: 25px!important;
    font-size: 18px!important;
    font-weight: 700!important;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

input[type="number"] {
  -moz-appearance: textfield;
  -webkit-appearance: none;
}

.input-group {
  clear: both;
  margin: 15px 0;
  position: relative;
  display: flex;
    justify-content: space-between;
}

.input-group input[type='button'] {
  background-color: #eeeeee;
  min-width: 38px;
  width: auto;
  transition: all 300ms ease;
}

.input-group .button-minus,
.input-group .button-plus {
  font-weight: bold;
  height: 38px;
  padding: 0;
  width: 38px;
  position: relative;
  background-color: #4A89DC!important;
  color: #fff!important;
}

.input-group .quantity-field {
  position: relative;
  height: 38px;
  
  text-align: center;
  width: 75%!important;
  display: inline-block;
  font-size: 13px;
  margin: 0 0 5px;
  resize: vertical;
}

.button-plus {
  left: -13px;
}
.infobarcode {
    display: none!important;
}

</style>
<audio id="sound" src="alert.mp3" preload="auto"></audio>
<form action="" type="POST" id="salvaresult">
  <input type="hidden"  placeholder="User"   id="idcart" name="idcart" style="max-width:400px" value="<?php echo $_COOKIE['user'];  ?>"readonly   /><br>
    <input type="number" placeholder="BARCODE"  id="result" name="result" style="max-width:400px" required  maxlength="13" size="13" maxsize="13"
     autofocus /><br>
     <input type="number"  placeholder="Quantità"   id="qta" name="qta" style="max-width:400px" required/><br>
    <input type="text"  placeholder="Descrizione"   id="descri" name="descri" style="max-width:400px" maxlength="10" size="10" maxsize="10" readonly required /><br>
    <input type="number"  placeholder="Prezzo"   id="prezzo" name="prezzo" style="max-width:400px" readonly required data-decimal="2" oninput="enforceNumberValidation(this)" step="any" /><br>
    <input type="submit" value="Salva" name="salvacart" id="salvadat"/>
    <input type="button" value="Ripristina" name="resetcart" id="resetcart" onClick="resetnput();"/>
</form>
<script>





  var intervalId = window.setInterval(function(){
    var strdiv=document.getElementById('numprod');
    if(strdiv==null){
         location.reload();
    }
  }, 500);
</script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

function enforceNumberValidation(ele) {
    if ($(ele).data('decimal') != null) {
        // found valid rule for decimal
        var decimal = parseInt($(ele).data('decimal')) || 0;
        var val = $(ele).val();
        if (decimal > 0) {
            var splitVal = val.split('.');
            if (splitVal.length == 2 && splitVal[1].length > decimal) {
                // user entered invalid input
                $(ele).val(splitVal[0] + '.' + splitVal[1].substr(0, decimal));
            }
        } else if (decimal == 0) {
            // do not allow decimal place
            var splitVal = val.split('.');
            if (splitVal.length > 1) {
                // user entered invalid input
                $(ele).val(splitVal[0]); // always trim everything after '.'
            }
        }
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
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}



const input = document.getElementById("result");
//input.addEventListener('change', updateValue);
input.addEventListener('focusout', updateValue);


function updateValue(e) {
        var val0=document.getElementById("result").value;
    if(val0!='')
    {
      if (val0.length > 13){
        document.getElementById("result").value = val0.slice(0, 13);  
      }else{
          val0=val0.toString().padStart(13, '0')
           document.getElementById("result").value = val0; 
      }
    } 
    
     var qrCodeMessage =document.getElementById("result").value;
     //e.target.value;
     if(qrCodeMessage!=''){
        console.log("Codice a Barre: "+qrCodeMessage);
          
    
        var txtcartv = document.getElementById('idcart').value;
        var idcam = "";
        const arr = [qrCodeMessage, txtcartv, idcam];
        
        
        const jsonString = JSON.stringify(arr);
        
        //const jsonString = JSON.stringify(Object.assign({}, dataj))
        console.log("jsonStrin=:" + jsonString);
        $.ajax({
            url: 'getprod.php',
            type: 'post',
            data: {
                textbarcode: jsonString
            },
            success: function(response) {
                console.log(response);
                const obj = JSON.parse(response);
                var barcd = obj.barcode;
                if (barcd == '') {
                      document.getElementById('sound').play();
                    alert("Codice non presente");
                     document.getElementById('result').vaue='';
                     document.getElementById('descri').vaue='';
                     document.getElementById('prezzo').vaue='';
                     document.getElementById("descri").readOnly = false;
                    document.getElementById("prezzo").readOnly = false;
                    document.getElementById('qta').value =1;
                     document.getElementById('qta').focus();
                } else {
                    var qta = obj.qta;
                    var dscri=obj.descri;
                   var price= obj.prezzo;
                  var price0=price.replace("\r\n", "");
                   console.log(price0);
                    document.getElementById("descri").readOnly = true;
                    document.getElementById("prezzo").readOnly = true;
                    document.getElementById('descri').value = obj.descri;
                    document.getElementById('result').value =qrCodeMessage;
                    document.getElementById('prezzo').value =price0.replace(",", ".");
                    if(qta=='' || qta==0  || qta==null )
                    {
                        qta=1;
                    }
                    else{
                        qta=parseInt(obj.qta)+1;
                    }
                    document.getElementById('qta').value =qta;
                    document.getElementById('qta').focus();
                }
        
        
            }
        });
     }

    
    
}
function resetnput(){
    document.getElementById('result').value ='';
    document.getElementById('qta').value ='';
    document.getElementById('descri').value ='';
    document.getElementById('prezzo').value ='';
    document.getElementById("result").focus();
   
}


</script>

<?php




if(isset($_GET['salvacart']))
{
    
    $barcode=$_GET['result'];
    $prezzo_1=$_GET['prezzo'];
    $descri_1=$_GET['descri'];
    $qta=$_GET['qta'];
    if($qta=='' || $qta==0){
        $qta=1;
    }
    if(strlen($barcode)<13 && $barcode!=''){
       $barcode=str_pad($barcode, 13, "0", STR_PAD_LEFT); 
    }
    $cart=$_COOKIE['user'];

    if($barcode!='' && $barcode!='0000000000000')
    {
           	if ($conn->connect_error) {
        			$connect=false;
        		  die("Connection failed: " . $conn->connect_error);
        	}else{
        	    
    		$sql0 = "SELECT count(barcode)as nbr from  export  where barcode='".$barcode."' and cart='".$cart."'  ";
    
            $result = mysqli_query($conn, $sql0);
            $row = mysqli_fetch_array($result);
    		$nbrresult=0;
    		$nbrresult =$row["nbr"];

    		if($nbrresult==0){
    		    
                $sql11 = "SELECT descri,prezzo,count(barcode)as nbr from  import  where barcode='".$barcode."' group by descri,prezzo  ";

                $result11 = mysqli_query($conn, $sql11);
                $row11 = mysqli_fetch_array($result11);
                if(count($row11)>0)
                {
                    $nbrresult11 =$row11["nbr"]; 
                   // $qta=1;  
                    $prezzo=$row11["prezzo"]; 
                    
                    
                    $prix=ltrim($prezzo, "0");
                    if(substr($prix,0,1)==','){$prix="0".$prix;}
                    $prezzo=$prix; 

    
    
                    $descri=$row11["descri"]; 
                    if(strpos($descri,"'")!==false){
                      $descri=str_replace("'","''",$descri);
                    }
                    if($nbrresult11>0)
                    {
                        $sql_insert = "INSERT INTO export(barcode, descri, prezzo,qta,cart) VALUES ('".$barcode."','".$descri."','".$prezzo."','".$qta."','".$cart."')"; 
                         $result_insert=$conn->query($sql_insert);
                    
                          
                    }else{
                         $sql_insert = "INSERT INTO export(barcode,qta,cart,descri, prezzo,esiste) VALUES ('".$barcode."','".$qta."','".$cart."','".$descri_1."','".$prezzo_1."','no')"; 
                            
                            
                          $result_insert=$conn->query($sql_insert);
                    $message = "Il prodotto non è presente sul database. Verrà comunque aggiunto al carrello.";
                    echo "<script type='text/javascript'>alert('$message');
                   </script>";
                  
                    }
                }else{  
                    $sql_insert = "INSERT INTO export(barcode,qta,cart,descri, prezzo,esiste) VALUES ('".$barcode."','".$qta."','".$cart."','".$descri_1."','".$prezzo_1."','no')"; 
                          $result_insert=$conn->query($sql_insert);
                    $message = "Il prodotto non è presente sul database. Verrà comunque aggiunto al carrello.";
                    echo "<script type='text/javascript'>alert('$message');
                   </script>";
                
                  
                }

        		}else{
        		    $sql_update="UPDATE  export SET qta='".$qta."' where barcode='".$barcode."'  and cart='".$cart."' ";
        			$result_update=$conn->query($sql_update);	
        			
        	}
        } 

    echo '<script>document.getElementById("ricaricapagina").click();</script>';
    }

}

?>
<!--------------------------------------------------------------------------->

            </div>
        </div>


    

     
           
    

        <a href="#" data-toggle-theme>
            <div class="card card-style">
                <div class="d-flex pt-3 mt-1 mb-2 pb-2">
                    <div class="align-self-center">
                        <i class="color-icon-gray color-gray-dark font-30 icon-40 text-center fa fa-moon ms-3 show-on-theme-light"></i>
                        <i class="color-icon-yellow color-yellow-dark font-30 icon-40 text-center fa fa-sun ms-3 show-on-theme-dark"></i>
                    </div>
                    <div class="align-self-center">
                        <p class="ps-2 ms-1 color-highlight font-500 mb-n1 mt-n2">Tap to Enable</p>
                        <h4 class="show-on-theme-light ps-2 ms-1 mb-0">Dark Mode</h4>
                        <h4 class="show-on-theme-dark ps-2 ms-1 mb-0">Light Mode</h4>
                    </div>
                    <div class="ms-auto align-self-center mt-n2">
                        <div class="custom-control small-switch ios-switch me-3 mt-n2">
                            <input data-toggle-theme type="checkbox" class="ios-input" id="toggle-dark-home">
                            <label class="custom-control-label" for="toggle-dark-home"></label>
                        </div>
                    </div>
                </div>
            </div>
        </a>
  </div>  
        <!--<div data-menu-load="menu-footer.html"></div>-->


    </div>
    <!-- End of Page Content-->
    <!-- All Menus, Action Sheets, Modals, Notifications, Toasts, Snackbars get Placed outside the <div class="page-content"> -->

    <!-- Menu Share -->
    <div id="menu-share" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title mt-n1"><h1>Share the Love</h1><p class="color-highlight">Just Tap the Social Icon. We'll add the Link</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="content mb-0">
            <div class="divider mb-0"></div>
            <div class="list-group list-custom-small list-icon-0">
                <a href="auto_generated" class="shareToFacebook external-link">
                    <i class="font-18 fab fa-facebook-square color-facebook"></i>
                    <span class="font-13">Facebook</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="auto_generated" class="shareToTwitter external-link">
                    <i class="font-18 fab fa-twitter-square color-twitter"></i>
                    <span class="font-13">Twitter</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="auto_generated" class="shareToLinkedIn external-link">
                    <i class="font-18 fab fa-linkedin color-linkedin"></i>
                    <span class="font-13">LinkedIn</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="auto_generated" class="shareToWhatsApp external-link">
                    <i class="font-18 fab fa-whatsapp-square color-whatsapp"></i>
                    <span class="font-13">WhatsApp</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="auto_generated" class="shareToMail external-link border-0">
                    <i class="font-18 fa fa-envelope-square color-mail"></i>
                    <span class="font-13">Email</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Be sure this is on your main visiting page, for example, the index.html page-->
    <!-- Install Prompt for Android -->
  <!--  <div id="menu-install-pwa-android" class="menu menu-box-bottom rounded-m">
        <img class="mx-auto mt-4 rounded-m" src="app/icons/icon-128x128.png" alt="img" width="90">
        <h4 class="text-center mt-4 mb-2">Installa Giocat</h4>
        <p class="text-center boxed-text-xl">
            Installa Giocat sul tuo dispositivo è semplice e veloce!
        </p>
        <div class="boxed-text-l">
            <a href="#" class="pwa-install mx-auto btn btn-m font-600 bg-highlight">Installa</a>
            <a href="#" class="pwa-dismiss close-menu btn-full mt-3 pt-2 text-center text-uppercase font-600 color-red-light font-12 pb-4 mb-3">Forse dopo</a>
        </div>
    </div>
-->
    <!-- Install instructions for iOS -->
<!--    <div id="menu-install-pwa-ios" class="menu menu-box-bottom rounded-m">
        <div class="boxed-text-xl top-25">
            <img class="mx-auto mt-4 rounded-m" src="app/icons/icon-128x128.png" alt="img" width="90">
            <h4 class="text-center mt-4 mb-2">Installa Giocat</h4>
            <p class="text-center ms-3 me-3">
                Installa Giocat sul tuo dispositivo è semplice e veloce!Apri il menu di safari e spingi "Aggiungi ad Home".
            </p>
            <a href="#" class="pwa-dismiss close-menu btn-full mt-3 text-center text-uppercase font-700 color-red-light opacity-90 font-110 pb-5">Forse dopo</a>
        </div>
    </div>
-->
</div>

<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>

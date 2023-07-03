<?php
setcookie("notificationShown", "", time() - 3600, "/");
session_start();
session_destroy();
header('Location: index.php');
exit;
?>
<script>
    function logout() {
        // Elimina il cookie "notificationShown"
        document.cookie = "notificationShown=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        // Altri codici per effettuare il logout
    }
</script>
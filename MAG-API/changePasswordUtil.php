<?php
// Funzione per cambiare la password dell'utente
function changePassword($username, $oldPassword, $newPassword, $confirmPassword)
{
    $filename = "users.json";

    // Leggi il contenuto del file JSON
    $jsonString = file_get_contents($filename);
    $data = json_decode($jsonString, true);

    $users = $data['users'];

    $info[] = '';

    // Cerca l'utente corrispondente all'username
    foreach ($users as $key => $user) {
        if ($user['username'] === $username) {
            // Verifica la vecchia password
            if ($user['password'] !== $oldPassword) {

                $info['oldNotMatch'] = true;
                return json_encode($info);
            }

            // Verifica la nuova password e la conferma della nuova password
            if ($newPassword !== $confirmPassword) {

                $info['checkNotMatch'] = true;

                return json_encode($info);
            }

            // Aggiorna la password
            $users[$key]['password'] = $newPassword;

            // Sovrascrivi il campo 'users' all'interno dell'array 'data'
            $data['users'] = $users;

            // Salva i dati nel file JSON
            $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents($filename, $newJsonString);

            $info['success'] = true;

            return json_encode($info);
        }
    }

    $info['notFound'] = true;

    return json_encode($info);
}

// AJAX Data
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $oldPassword = $_POST['password_old'];
    $newPassword = $_POST['password_new'];
    $confirmPassword = $_POST['password_check'];

    $result = changePassword($username, $oldPassword, $newPassword, $confirmPassword);
    echo $result;
}

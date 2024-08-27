<?php

@include 'config.php';

session_start();

$membre_id = $_SESSION['membre_id'];


if (isset($_POST['emprunté'])) {


    $date = date('Y-m-d');

    $livre = $_POST['Livre'];
    $livre = filter_var($livre, FILTER_SANITIZE_STRING);

    $id_L = $_POST['id_Li'];
    $id_L = filter_var($id_L, FILTER_SANITIZE_STRING);

    $check = $conn->prepare("SELECT * FROM ` emprunts` WHERE Livre = ? AND membre_id= ? AND id_L = ? ");
    $check->execute([$livre, $membre_id, $id_L]);

    if ($check->rowCount() > 0) {
        $message[] = 'deja ajouté ';
    }


    $insert_emprunt = $conn->prepare("INSERT INTO `emprunts`( membre_id, Livre,id_L, date  ) VALUES(?,?,?,?)");
    $insert_emprunt->execute([$membre_id, $livre, $id_L, $date]);

    if ($insert_emprunt->rowCount() > 0) {
        $message[] = 'emprunts ajouté';
    } else {
        $errorInfo = $insert_emprunt->errorInfo();
        $message[] = 'Erreur lors de l\'ajout de emprunts : ' . $errorInfo[2];
    }

}


?>
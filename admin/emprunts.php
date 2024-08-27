<?php

@include '../modele/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];



if (!isset($admin_id)) {
    header('location: ../login.php');
}

if (isset($_POST['update_emprunts'])) {

    $emprunt_id = $_POST['emprunt_id'];

    $id_L = $_POST['id_Li'];
    $id_L = filter_var($id_L, FILTER_SANITIZE_STRING);

    $update_status = $_POST['status'];
    $update_status = filter_var($update_status, FILTER_SANITIZE_STRING);

    $update_emprunts = $conn->prepare("UPDATE `emprunts` SET status_livres = ? WHERE id = ?");
    $update_emprunts->execute([$update_status, $emprunt_id]);

    $update_livre = $conn->prepare("UPDATE `livres` SET status_L = ? WHERE id= ?");
    $update_livre->execute([$update_status, $id_L]);

    $message[] = 'status mise a jour !';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];



    $delete_emprunts = $conn->prepare("DELETE FROM `emprunts` WHERE id = ?");
    $delete_emprunts->execute([$delete_id]);

}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../assets/css/admin_style.css">


</head>

<body>

    <?php include 'admin_header.php'; ?>


    <section class="placed-orders">

        <h1 class="title">Liste des emprunts</h1>

        <div class="box-container">

            <?php
            $select_emprunts = $conn->prepare("SELECT * FROM `emprunts`");
            $select_emprunts->execute();
            if ($select_emprunts->rowCount() > 0) {
                while ($fetch_emprunts = $select_emprunts->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="box">

                        <div class="id">
                            <p>Id de l'emprunts :</p>
                            <?= $fetch_emprunts['id']; ?>
                        </div>
                        <div class="membre_id">
                            <p>Id de l'emprunteur :</p>
                            <?= $fetch_emprunts['membre_id']; ?>
                        </div>

                        <div class="Titre">
                            <p>Nom du livre empruntés :</p>
                            <?= $fetch_emprunts['Livre'] ?>
                        </div>

                        <div class="date d'emprunt">
                            <p>Date d'emprunts :</p>
                            <?= $fetch_emprunts['date'] ?>
                        </div>

                        <div class="Date retour">
                            <p>Date de retour :</p>


                            <input type="hidden" value="<?= $date = $fetch_emprunts['date']; ?>">
                            <input type="hidden" value="<?= $date_retour_timestamp = strtotime($date) + (14 * 86400); ?>">
                            <input type="hidden" value="<?= $date_retour = date('Y-m-d', $date_retour_timestamp); ?>">

                            <?=
                                $date_retour
                                ?>

                        </div>


                        <div class="status_livres">

                            <form action="" method="POST">

                                <input type="hidden" name="emprunt_id" value="<?= $fetch_emprunts['id']; ?>">
                                <input type="hidden" name="id_Li" value="<?= $fetch_emprunts['id_L']; ?>">

                                <select name="status" class="drop-down">
                                    <option value="" selected disabled>
                                        <?= $fetch_emprunts['status_livres']; ?>
                                    </option>

                                    <option value="en cours emprunts">en cours emprunts</option>
                                    <option value="possesion">possesion</option>
                                    <option value="disponible">disponible</option>

                                </select>

                                <div class="flex-btn">
                                    <input type="submit" name="update_emprunts" class="option-btn" value="Metre a jour">

                                    <a href="emprunts.php?delete=<?= $fetch_emprunts['id']; ?>" class="delete-btn"
                                        onclick="return confirm('Supprimer cette emprunts?');">Supprimer</a>

                                </div>

                            </form>
                        </div>

                    </div>

            </section>
            <?php
                }
            } else {
                echo '<p class="empty">Pas encore d emprunts!</p>';
            }
            ?>

</body>
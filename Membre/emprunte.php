<?php

@include '../modele/config.php';
@include '../modele/emprunt.php';
error_reporting(0);

session_start();

$membre_id = $_SESSION['membre_id'];

if (!isset($membre_id)) {
    header('location : ../login.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprunts</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/bootstrap-icons.css">
    <link rel="shortcut icon " href="assets/image/logo mimoz.png">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../assets/css/style.css">


</head>

<body>
    <?php include 'header.php'; ?>

    </section>

    <section class="products">

        <h1 class="title">Vos emprunts</h1>

        <div class="box-container">

            <?php
            $select_products = $conn->prepare("SELECT * FROM `emprunts`  WHERE membre_id = $membre_id ");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form action="" class="box" method="POST">

                        <div class="name">
                            <h3>Titre du livre :</h3>

                            <?= $fetch_products['Livre']; ?>

                        </div>

                        <div class="name">

                            <h3>Date d'emprunts :</h3>

                            <?= $fetch_products['date']; ?>
                        </div>
                        <div class="name">

                            <h3>Date de retour :</h3>


                            <input type="hidden" value="<?= $date = $fetch_products['date']; ?>">
                            <input type="hidden" value="<?= $date_retour_timestamp = strtotime($date) + (14 * 86400); ?>">
                            <input type="hidden" value="<?= $date_retour = date('Y-m-d', $date_retour_timestamp); ?>">

                            <?=
                                $date_retour
                                ?>
                        </div>

                    </form>
                    <?php
                }
            } else {
                echo '<p class="empty">Pas de Livres empruntés!</p>';
            }
            ?>

        </div>

    </section>



    <script src="assets/js/script.js"></script>
    <script src="assets/js/bootstrap.bundle.js"></script>
</body>

</html>
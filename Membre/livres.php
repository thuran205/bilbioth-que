<?php

@include '../modele/config.php';

@include '../modele/emprunt.php';
@include '../modele/search_page.php';

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
    <title>Livres</title>
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

    <section class="products">



        <section class="search-form">

            <form action="" method="POST">
                <input type="text" class="box" name="search_box" placeholder="Rechercher un livre...">
                <input type="submit" name="search_btn" value="search" class="btn">
            </form>

        </section>

        <h1 class="title">Nos Livres</h1>

        <div class="box-container">

            <?php
            $select_products = $conn->prepare("SELECT * FROM `livres` ");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form action="" class="box" method="POST">

                        <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                        <div class="name">

                            <h3>Titre :</h3>
                            <?= $fetch_products['Titre']; ?>
                        </div>
                        <div class="name">

                            <h3>Auteur :</h3>
                            <?= $fetch_products['Auteur']; ?>
                        </div>

                        <div class="name">

                            <h3>Synopsis :</h3>
                            <?= $fetch_products['Synopsis']; ?>
                        </div>
                        <div class="name">

                            <h3>status :</h3>
                            <?= $fetch_products['status_L']; ?>
                        </div>

                        <input type="hidden" name="Livre" value="<?= $fetch_products['Titre']; ?>">
                        <input type="hidden" name="id_Li" value="<?= $fetch_products['id']; ?>">
                        <input type="submit" value="emprunté" class="btn" name="emprunté">
                    </form>
                    <?php
                }
            } else {
                echo '<p class="empty">Pas de Livres ajoutez!</p>';
            }
            ?>

        </div>

    </section>



    <script src="assets/js/script.js"></script>
    <script src="assets/js/bootstrap.bundle.js"></script>
</body>

</html>
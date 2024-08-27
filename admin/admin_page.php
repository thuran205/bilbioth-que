<?php

@include '../modele/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: ../login.php');
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



    <section class="dashboard">

        <h1 class="title">Page d'acceuil</h1>




        <div class="box-container">


            <div class="box">
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `emprunts`");
                $select_orders->execute();
                $number_of_orders = $select_orders->rowCount();
                ?>
                <h3>
                    <?= $number_of_orders; ?>
                </h3>
                <p>Les emprunts</p>
                <a href="emprunts.php" class="btn">voir les emprunts</a>
            </div>

            <div class="box">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `livres`");
                $select_products->execute();
                $number_of_products = $select_products->rowCount();
                ?>
                <h3>
                    <?= $number_of_products; ?>
                </h3>
                <p>Livres ajoutés</p>
                <a href="livre.php" class="btn">voir les livres</a>
            </div>

            <div class="box">
                <?php
                $select_users = $conn->prepare("SELECT * FROM `users` WHERE status = ?");
                $select_users->execute(['me']);
                $number_of_users = $select_users->rowCount();
                ?>
                <h3>
                    <?= $number_of_users; ?>
                </h3>
                <p>totale utilisateurs</p>
                <a href="admin_users.php" class="btn">Voir les Utilsateurs</a>
            </div>


            <div class="box">
                <?php
                $select_accounts = $conn->prepare("SELECT * FROM `users`");
                $select_accounts->execute();
                $number_of_accounts = $select_accounts->rowCount();
                ?>
                <h3>
                    <?= $number_of_accounts; ?>
                </h3>
                <p>totale comptes</p>
                <a href="admin_users.php" class="btn">Voir les comptes</a>
            </div>


        </div>

    </section>

    <script src="../assets/js/script.js"></script>
</body>

</html>
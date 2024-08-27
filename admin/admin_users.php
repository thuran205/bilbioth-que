<?php
@include '../modele/config.php';

session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: ../login.php');
}


if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_users->execute([$delete_id]);

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../assets/css/admin_style.css">


</head>

<body>

    <?php include 'admin_header.php'; ?>


    <section class="user-accounts">

        <h1 class="title">Membres</h1>

        <form> <a href="enregistrez.php" class="btn">Ajouter un Utilisateur</a></form>
        <div class="box-container">

            <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box" style="<?php if ($fetch_users['id'] == $admin_id) {
                    echo 'display:none';
                }
                ; ?>">

                    <p> CIN : <span>
                            <?= $fetch_users['CIN']; ?>
                        </span></p>
                    <p> Nom : <span>
                            <?= $fetch_users['Nom']; ?>
                        </span></p>
                    <p> Email : <span>
                            <?= $fetch_users['Email']; ?>
                        </span></p>
                    <p> Type d'Utilisateur : <span style=" color:<?php if ($fetch_users['status'] == 'admin') {
                        echo 'orange';
                    }
                    ; ?>"><?= $fetch_users['status']; ?></span></p>
                    <a href="admin_users.php?delete=<?= $fetch_users['id']; ?>"
                        onclick="return confirm('delete this user?');" class="delete-btn">Supprimer</a>
                </div>
                <?php
            }


            ?>

        </div>

    </section>

    <script src="../assets/js/script.js"></script>

</body>

</html>
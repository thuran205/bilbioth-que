<?php
@include 'modele/config.php';

session_start();

if (isset($_POST['submit'])) {

    $email = $_POST['Email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM `users` WHERE Email = ? AND mdp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $pass]);
    $rowCount = $stmt->rowCount();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rowCount > 0) {

        if ($row['status'] == 'admin') {

            $_SESSION['admin_id'] = $row['id'];
            header('location:admin/admin_page.php');

        } elseif ($row['status'] == 'membre') {

            $_SESSION['membre_id'] = $row['id'];
            header('location:Membre/home.php');

        } else {
            $message[] = 'Utilisateur non trouver!';
        }

    } else {
        $message[] = 'Adresse mail ou mot de passe incorrect!';
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="assets/css/components.css">

</head>

<body>

    <?php

    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }

    ?>

    <section class="form-container">

        <form action="" method="POST">
            <h3>Se connecter</h3>
            <input type="email" name="Email" class="box" placeholder="entrez votre adresse mail" required>
            <input type="password" name="pass" class="box" placeholder="entrez votre mot de passe" required>
            <input type="submit" value="Se connectez" class="btn" name="submit">
        </form>

    </section>


</body>

</html>
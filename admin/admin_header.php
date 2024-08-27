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

<header class="header">

    <div class="flex">

        <a href="admin_page.php" class="logo">Gestion<span>Bibliothéque</span></a>

        <nav class="navbar">
            <a href="admin_page.php">Aceuil</a>
            <a href="livre.php">Livres</a>
            <a href="emprunts.php">Emprunts</a>
            <a href="admin_users.php">Utilisateurs</a>
        </nav>



        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>


        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p>
                <?= $fetch_profile['Nom']; ?>
            </p>
            <a href="logout.php" class="delete-btn">Se deconnectez</a>

        </div>

    </div>

</header>
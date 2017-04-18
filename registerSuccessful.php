<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<script src="js/jquery-3.1.1.js"></script>
	<script src="js/moveAnimation.js"></script>
	<title>Magebit</title>
	<?php
        include("php/UserControl.php");
        try {
            $user = UserControl::getUser();
            UserControl::redirect($user, "registerSuccessful.php");
        } catch(Exception $e) {
            session_destroy();
            header("Location: index.php?error=" . $e->getMessage());
        }
    ?>
</head>
<body>
    <div id="bg">
        <img src="./images/background.png" alt="" onload="zoomIn(this)">
    </div>

    <main>
        <div class="half-panel">
            <div class="account-title">Registration successful!</div>
            <div class="blue-line"></div>
            <div class="account-text">
                <a href="index.php" class="back-panel-btn">Home</a>
            </div>
        </div>
    </main>
    <footer>
        ALL RIGHTS RESERVED "MAGEBIT" 2016.
    </footer>
</body>
</html>
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
            UserControl::redirect($user, "welcome.php");
            $data = $user -> getData();
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

    <?php if(isset($_GET["error"])) {
        echo "<div class='top-msg msg-error'>" . $_GET['error'] . "</div>";
    } else if(isset($_GET["success"])) {
        echo "<div class='top-msg msg-success'>" . $_GET['success'] . "</div>";
    }
    ?>

	<main>
		<div class="half-panel">
			<div class="account-title">Hello <?php echo $data["name"] ?>!</div>
			<div class="blue-line"></div>
			<div class="account-text">
				<a href="profile.php" class="back-panel-btn">Edit profile</a>

                <?php
                    if (is_a($user, "AdminProfile")) {
                        echo "<a href='manage.php' class='back-panel-btn'>Manage attributes</a> <br>";
                    }
                ?>
				<form action="php/authentHandler.php" method="POST">
					<input type="submit" name="submit-logout" class="submit-btn" value="LOGOUT">
				</form>
			</div>
			
		</div>
	</main>
	<footer>
		ALL RIGHTS RESERVED "MAGEBIT" 2016.
	</footer>
</body>
</html>
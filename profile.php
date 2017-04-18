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
            UserControl::redirect($user, "profile.php");
            $data = $user -> getData();
            $attributes = $user -> getAttributes();
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
			<div class="account-title">Profile data</div>
			<div class="blue-line"></div>
			<div class="account-text">
				<form action="php/profileHandler.php" method="POST">
					<div>
						<div class="align-left">Name: </div>
						<div class="align-right">
							<input class="edit-field" type="text" name="name" value="<?php echo $data['name'] ?>">
						</div>
						<div class="both"></div>
					</div>
					<div>
						<div class="align-left">Email: </div>
						<div class="align-right">
							<input class="edit-field" type="text" name="email" value="<?php echo $data['email'] ?>">
						</div>
						<div class="both"></div>
					</div>

					<input type="submit" name="submit-edit-data" class="submit-btn" value="SUBMIT">
				</form>
			</div>
            <a href="changePassword.php" class="back-panel-btn">Change password</a>

            <a href="welcome.php" class="back-panel-btn">Back</a>
		</div
		><div class="half-panel">
			<div class="account-title">Profile attributes</div>
			<div class="blue-line"></div>
			<div class="account-text">
				<form action="php/profileHandler.php" method="POST">
					<?php
                        if (count($attributes)) {
                            foreach ($attributes as $key => $value) {
                                echo "<div>
                                        <div class='align-left'>$key: </div>
                                        <div class='align-right'>
                                            <input class='edit-field' type='text' name='$key' value='$value'>
                                        </div>
                                        <div class='both'></div>
                                    </div>
                                    ";
                            }
                            echo "<br><input type='submit' name='submit-edit-attr' class='submit-btn' value='SUBMIT'>";
                        } else {
                            echo "<p>------EMPTY------</p>";
                        }
					?>
				</form>
			</div>
		</div>
	</main>
	<footer>
		ALL RIGHTS RESERVED "MAGEBIT" 2016.
	</footer>
</body>
</html>
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
            UserControl::redirect($user, "index.php");
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
		<div class="half-panel" id="signup-info">
			<div class="account-title">Don't have an account?</div>
			<div class="blue-line"></div>
			<div class="account-text">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			</div>
			<a href="javascript:animFrontPanel()" class="back-panel-btn">SIGN UP</a>
		</div

		><div class="half-panel hidden" id="login-info">
			<div class="account-title">Have an account?</div>
			<div class="blue-line"></div>
			<div class="account-text">
				Lorem ipsum dolor sit amet consectetur adipisicing elit.
			</div>
			<a href="javascript:animFrontPanel()" class="back-panel-btn">LOGIN</a>
		</div>

		<div id="front-container">
			<div id="front">
				<div id="login-content">
					
					<div>
						<div class="front-title align-left">Login</div>
						<img class="align-right" src="./images/logo.png" alt="">
						<div class="both"></div>
					</div>

					<div class="blue-line"></div>

					<form accept-charset="utf-8" action="php/authentHandler.php" method="post">

						<div class="input-container">
							<div class="input-title">
								<div class="align-left">Email<span class="required">*</span></div>
								<img class="align-right" src="./images/ic_mail.png" alt="">
								<div class="both"></div>
							</div>
							<input type="text" name="email" onfocus="inputFocus(this)" onblur="inputBlur(this)">
						</div>

						<div class="input-container">
							<div class="input-title">
								<div class="align-left">Password<span class="required">*</span></div>
								<img class="align-right" src="./images/ic_lock.png" alt="">
								<div class="both"></div>
							</div>
							<input type="Password" name="password" onfocus="inputFocus(this)" onblur="inputBlur(this)">
						</div>

						<div class="submit-row">
							<div class="align-left">
								<input class="submit-btn" type="submit" name="submit-login" value="LOGIN">
							</div>
							<a href="#" class="align-right input-title center-vertical">Forgot?</a>
							<div class="both"></div>
						</div>

					</form>
				</div>

				<div id="register-content">
					
					<div>
						<div class="front-title align-left">Sign Up</div>
						<img class="align-right" src="./images/logo.png" alt="">
						<div class="both"></div>
					</div>

					<div class="blue-line"></div>

					<form action="php/authentHandler.php" method="post">

						<div class="input-container">
							<div class="input-title">
								<div class="align-left">Name<span class="required">*</span></div>
								<img class="align-right" src="./images/ic_user.png" alt="">
								<div class="both"></div>
							</div>
							<input type="text" name="name" onfocus="inputFocus(this)" onblur="inputBlur(this)">
						</div>

						<div class="input-container">
							<div class="input-title">
								<div class="align-left">Email<span class="required">*</span></div>
								<img class="align-right" src="./images/ic_mail.png" alt="">
								<div class="both"></div>
							</div>
							<input type="text" name="email" onfocus="inputFocus(this)" onblur="inputBlur(this)">
						</div>

						<div class="input-container">
							<div class="input-title">
								<div class="align-left">Password<span class="required">*</span></div>
								<img class="align-right" src="./images/ic_lock.png" alt="">
								<div class="both"></div>
							</div>
							<input type="Password" name="password" onfocus="inputFocus(this)" onblur="inputBlur(this)">
						</div>

						<div class="submit-row">
							<input class="submit-btn" type="submit" name="submit-register" value="SIGN UP">
						</div>

					</form>
				</div>

				<div id="side-fold">
					<img id="top-fold" src="./images/small_fold.png" alt="">
					<div id="middle-fold"></div>
					<img id="bottom-fold" src="./images/small_fold.png" alt="">
				</div>
			</div>
		</div>
	</main>
	<footer>
		ALL RIGHTS RESERVED "MAGEBIT" 2016.
	</footer>
</body>
</html>
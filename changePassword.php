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
            UserControl::redirect($user, "changePassword.php");
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
            <div class="account-title">Change password</div>
            <div class="blue-line"></div>
            <div class="account-text">
                <form action="php/profileHandler.php" method="post">
                    <div>
                        <div class="align-left">Old password: </div>
                        <input type="password" name="passw" class="align-right">
                        <div class="both"></div>
                    </div>
                    <div>
                        <div class="align-left">New password: </div>
                        <input type="password" name="new-passw" class="align-right">
                        <div class="both"></div>
                    </div>
                    <div>
                        <div class="align-left">Confirm password: </div>
                        <input type="password" name="conf-passw" class="align-right">
                        <div class="both"></div>
                    </div>
                    <br>
                    <input type="submit" name="submit-password" class="submit-btn" value="SUBMIT">
                </form>
            </div>
            <a href="profile.php" class="back-panel-btn">Back</a>
        </div>
    </main>
    <footer>
        ALL RIGHTS RESERVED "MAGEBIT" 2016.
    </footer>
</body>
</html>
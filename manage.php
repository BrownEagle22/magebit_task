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
            UserControl::redirect($user, "manage.php");
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
            <div class="account-text">
                <strong>Add attribute</strong>
                <form action="php/manageAttrHandler.php" method="POST">
                    <input class='back-input' type="text" name="add">
                    <input type="submit" name="submit-add" class="submit-btn" value="ADD">
                </form>
				<br>
                <strong>Delete attribute</strong>
                <form action="php/manageAttrHandler.php" method="POST">
                    <input class='back-input' type="text" name="delete">
                    <input type="submit" name="submit-delete" class="submit-btn" value="DELETE">
                </form>
            </div>
        </div

        ><div class="half-panel">
            <div class="account-text">
                <strong>Rename attribute</strong>
                <form action="php/manageAttrHandler.php" method="POST">
                    <?php
                    if (count($attributes)) {
                        foreach ($attributes as $key => $value) {
                            echo "<input class='back-input' type='text' name='$key' value='$key'>";
                        }
                        echo "<input type='submit' name='submit-rename' class='submit-btn' value='SUBMIT'>";
                    } else {
                        echo "<p>------EMPTY------</p>";
                    }
                    ?>
                </form>
            </div>
			<a href="welcome.php" class="back-panel-btn">Back</a>
        </div>
    </main>
    <footer>
        ALL RIGHTS RESERVED "MAGEBIT" 2016.
    </footer>
</body>
</html>
<?php
include("UserControl.php");
include("Validation.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $user = UserControl::getUser();

        if (isset($_POST["submit-edit-data"])) {
            $name = Validation::validate("name", $_POST["name"], true);
            $email = Validation::validEmail($_POST["email"]);

            $data["name"] = $name;
            $data["email"] = $email;
            $user->setData($data);

            header("Location: ../profile.php?success=Data changed!");

        } else if (isset($_POST["submit-edit-attr"])) {
            unset($_POST["submit-edit-attr"]);

            $newAttr = array();
            foreach($_POST as $key => $value) {
                $value = Validation::validate($key, $value);
                $newAttr[$key] = $value;
            }

            if (count($newAttr) == 0) {
                header("Location: ../profile.php?error=Error, no attributes found!");
                die();
            }

            $user->setAttributes($newAttr);
            header("Location: ../profile.php?success=Attributes changed!");

        } else if (isset($_POST["submit-password"])) {
            $data = $user->getData();

            $oldPass = $_POST["passw"];
            $newPass = Validation::validPassword($_POST["new-passw"]);
            $confirmPass = Validation::validPassword($_POST["conf-passw"]);

            if (!password_verify($oldPass, $data["password"])) {
                throw new Exception("Error, wrong password!");
            }
            if ($newPass != $confirmPass) {
                throw new Exception("Error, passwords doesn't match!");
            }

            $newPass = password_hash($newPass, PASSWORD_BCRYPT);
            $data["password"] = $newPass;

            $user -> setData($data);
            header("Location: ../changePassword.php?success=Password changed!");
        }

    } catch (Exception $e) {
        header("Location: ../profile.php?error=" . $e->getMessage());
    }
}
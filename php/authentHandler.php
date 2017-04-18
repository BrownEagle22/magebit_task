<?php
include ("User.php");
include ("Validation.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        if (isset($_POST["submit-login"])) {
            $email = Validation::validEmail($_POST["email"]);
            $password = Validation::validPassword($_POST["password"]);
            User::login($email, $password);
            header("Location: ../welcome.php");

        } else if (isset($_POST["submit-register"])) {
            $email = Validation::validEmail($_POST["email"]);
            $password = Validation::validPassword($_POST["password"]);
            $name = Validation::validate("name", $_POST["name"], true);

            User::register($name, $email, $password);
            header("Location: ../registerSuccessful.php");

        } else if (isset($_POST["submit-logout"])) {
            User::logout();
            header("Location: ../index.php");
        }

    } catch (Exception $e) {
        header("Location: ../index.php?error=" . $e->getMessage());
    }
}
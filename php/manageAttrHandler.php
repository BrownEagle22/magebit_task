<?php
include("UserControl.php");
include("Validation.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $user = UserControl::getUser();
        $attributes = $user->getAttributes();

        if (isset($_POST["submit-rename"])) {
            unset($_POST["submit-rename"]);

            $newAttr = array();
            foreach ($_POST as $key => $value) {
                $key = str_replace("_", " ", $key);
                $value = Validation::validAttribute($value);
                $user->renameAttrCol($key, $value);
            }
            header("Location: ../manage.php?success=Attribute names has been changed!");

        } else if (isset($_POST["submit-delete"])) {
            $attr = $_POST["delete"];
            if (!array_key_exists($attr, $attributes)) {
                throw new Exception("Error, attribute '$attr' not found!");
            }
            $user->delAttrCol($attr);
            header("Location: ../manage.php?success=Attribute '$attr' deleted!");

        } else if (isset($_POST["submit-add"])) {
            $attr = $_POST["add"];
            if (array_key_exists($attr, $attributes)) {
                throw new Exception ("Error, attribute '$attr' already exists!");
            }
            $attr = Validation::validAttribute($attr);
            $user->addAttrCol($attr);
            header("Location: ../manage.php?success=Attribute '$attr' added!");
        }

    } catch (Exception $e) {
        header("Location: ../manage.php?error=" . $e->getMessage());
    }
}
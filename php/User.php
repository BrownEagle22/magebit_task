<?php
include("DbConnect.php");

/**
 * Allows to login, register and logout by using static functions.
 *
 * Functions get database connection by calling parent function connect().
 * Then sql commands are executed to login, logout or add new user. In case of error, exceptions are thrown
 *
 */
class User extends DbConnect {

    /**
     * Login with email and password
     *
     * Gets connection
     * Executes sql query to get user id and password who has the given email.
     * Session is started and session variable 'id' is set to user id.
     * Connection is closed
     *
     * @param string $email
     * @param string $passw
     *
     * @throws Exception If there is error executing SELECT query
     * @throws Exception If no users are found if table
     * @throws Exception If given password doesn't match user password
     *
     * @return void
     */
    public static function login($email, $passw) {
        $conn = self::connect();

        $sql = "SELECT id, password FROM " . self::userTable . " WHERE BINARY email='$email'";
        $result = $conn -> query($sql);
        if ($conn -> error) {
            throw new Exception("Error, something went wrong when logging in!");
        }

        if ($result -> num_rows == 0) {
            throw new Exception("Invalid email or password!");
        }

        $data = $result -> fetch_assoc();

        if (!password_verify($passw, $data["password"])) {
            throw new Exception("Invalid email or password!");
        }

        session_start();
        $_SESSION["id"] = $data["id"];

        $conn -> close();
    }

    /**
     * Creates a new user
     *
     * If given email isn't used, new 'attributes' table row is added.
     * Then new user in 'users' table is added with: given name, given email, hashed given password,
     * newly 'attributes' table row id ('attr_id')
     *
     * @param string $name
     * @param string $email
     * @param string $passw
     *
     * @throws Exception If there is error trying to get id with given email via sql
     * @throws Exception If user with given email already exists
     * @throws Exception If there is error trying to add row to 'attributes' table via sql
     * @throws Exception If there is error trying to add the new user via sql
     */
    public static function register($name, $email, $passw) {
        $conn = self::connect();

        $sql = "SELECT id FROM " . self::userTable . " WHERE email = '$email'";
        $result = $conn -> query($sql);
        if ($conn -> error) {
            throw new Exception("Error, something went wrong when registering!");
        }
        if ($result -> num_rows != 0) {
            throw new Exception("Error, email already exists!");
        }

        $passw = password_hash($passw, PASSWORD_BCRYPT);

        $sql = "INSERT INTO " . self::attrTable . " VALUES()";
        if (!$conn -> query($sql)) {
            throw new Exception("Error, something went wrong when registering!");
        }
        $attr_id = $conn -> insert_id;

        $sql = "INSERT INTO " . self::userTable . " (name, email, password, attr_id) VALUES ('$name', '$email', '$passw', '$attr_id')";
        if (!$conn -> query($sql)) {
            throw new Exception("Error, something went wrong when registering!");
        }

        $conn -> close();
    }

    /**
     * Logging user out by destroying sessions
     */
    public static function logout() {
        session_start();
        session_destroy();
    }
}
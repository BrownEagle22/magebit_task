<?php
/**
 * Holds different database constants and provides connection to database
 */

class DbConnect {
    const servername = "127.0.0.1";
    /**
     * MySQL username
     */
    const username = "root";
    /**
     * MySQL password
     */
    const password = "";
    /**
     * Database name, that will be used.
     */
    const dbName = "magebit_task";
    /**
     * Table name, that will hold users
     */
    const userTable = "users";
    /**
     * Table name, that will hold attributes
     */
    const attrTable = "attributes";

    /**
     * Creates connection with database and returns it as object
     *
     * @return mysqli connection object
     */
    public static function connect() {
        $conn = @new mysqli(self::servername, self::username, self::password, self::dbName);
        if ($conn -> connect_error) {
            die("<h3><strong>Database connection error</strong></h3>");
        }
        return $conn;
    }
}
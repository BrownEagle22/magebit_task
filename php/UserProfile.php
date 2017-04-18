<?php
include ("DbConnect.php");

/**
 * Allows to view and change user data, attributes.
 *
 * When creating object, id need to be given.
 * When object created, data and attributes are automatically loaded and stored in global variables.
 * It is possible to get, set data, attributes and also see if user is admin
 */
class UserProfile extends DbConnect {
    /**
     * @var array $data Associative array. Keys are 'users' table column names.
     */
    protected $data;
    /**
     * @var array $attributes Associative array. Keys are 'attributes' table column names.
     */
    protected $attributes;

    /**
     * UserProfile constructor.
     *
     * Loads data, attributes and stores them in global variables
     * @param int $id
     */
    function __construct($id) {
        $this -> loadData($id);
        $this -> loadAttr();
    }

    /**
     * Loads user data into global variable $data.
     *
     * User data is loaded from database table 'users' with given id
     *
     * @param int $id
     *
     * @return void
     *
     * @throws Exception if there is an error when executing SELECT query
     * @throws Exception if no results are found with given id
     */
    private function loadData($id) {
        $conn = self::connect();

        $sql = "SELECT * FROM " . self::userTable . " WHERE id='$id'";
        $result = $conn -> query($sql);
        if ($conn -> error) {
            throw new Exception("Error, something went wrong when creating user!");
        }
        if ($result -> num_rows == 0) {
            throw new Exception("Error, something went wrong when creating user!");
        }
        $data = $result -> fetch_assoc();

        $this -> data = $data;
        $conn -> close();
    }

    /**
     * Loads user attributes into global variable $attributes.
     *
     * Gets 'attribute' table row data about user from database.
     * Needed id is got from global variable $data.
     *
     * @throws Exception if $data doesn't have 'attr_id' set.
     * @throws Exception if there is error when executing SELECT query.
     * @throws Exception if no attribute data is found in 'attribute' table.
     */
    private function loadAttr() {
        $conn = self::connect();

        if (isset($this -> data["attr_id"])) {
            $id = $this -> data["attr_id"];
        } else {
            throw new Exception("Error, something went wrong when creating user!");
        }

        $sql = "SELECT * FROM " . self::attrTable . " WHERE id='$id'";
        $result = $conn -> query($sql);
        if ($conn -> error) {
            throw new Exception("Error, something went wrong when creating user!");
        }
        if ($result -> num_rows == 0) {
            throw new Exception("Error, something went wrong when creating user!");
        }
        $data = $result -> fetch_assoc();

        $this -> attributes = $data;

        $conn -> close();
    }

    /**
     * Returns data about user in an associative array
     *
     *
     * @return array Associative array, that holds data about user, except 'id' and 'attr_id'.
     */
    function getData() {
        $returnData = $this -> data;
        unset($returnData["id"]);
        unset($returnData["attr_id"]);
        return $returnData;
    }

    /**
     * Updates user data with given data.
     *
     * 'id' can't be updated.
     *
     * @param array $data Associative array with data names and values, that need to be changed.
     * @throws Exception if there is an error when executing UPDATE query
     */
    function setData($data) {
        $conn = self::connect();

        unset($data["id"]);
        $sets = "";
        foreach ($data as $key => $value) {
            $sets = $sets . "$key='$value',";
        }
        $sets = rtrim($sets, ",");

        $sql = "UPDATE " . self::userTable . " SET $sets WHERE id=" . $this -> data["id"];
        if (!$conn -> query($sql)) {
            throw new Exception("Error, something went wrong when changing user data!");
        }

        $conn -> close();
    }

    /**
     * Returns user attributes in an associative array
     *
     * 'id' isn't included in data.
     *
     * @return array Associative array with user attributes data
     */
    function getAttributes() {
        $returnAttr = $this -> attributes;
        unset($returnAttr["id"]);
        return $returnAttr;
    }

    /**
     * Updates user attributes with the given attributes
     *
     * 'attributes' table row id is got from global variable $data.
     *
     * @param array $data Associative array that holds attribute names and new values
     * @throws Exception if there is an error when executing UPDATE query
     */
    function setAttributes($data) {
        $conn = self::connect();

        $id = $this -> data["attr_id"];
        unset($data["id"]);

        $sets = "";
        foreach ($data as $key => $value) {
            $sets = $sets . "$key='$value',";
        }
        $sets = rtrim($sets, ",");

        $sql = "UPDATE " . self::attrTable . " SET $sets WHERE id=$id";
        if (!$conn -> query($sql)) {
            throw new Exception("Error, something went wrong when changing user attributes!");
        }

        $conn -> close();
    }

    /**
     * Returns true, if user is an admin
     *
     * If global variable $data key 'admin' is 1, return true, else false.
     *
     * @return bool
     */
    function isAdmin() {
        if ($this -> data["admin"] == 1) {
            return true;
        } else {
            return false;
        }
    }
}
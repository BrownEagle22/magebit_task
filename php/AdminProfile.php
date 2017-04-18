<?php

/**
 * Allows to view and change user data, attributes + alter 'attributes' tables
 *
 * 'attributes' table names can be renamed, deleted and added.
 * (default admin profile password is 'password'. To be an admin 'users' table column 'admin' value needs to be manually set to '1')
 */
class AdminProfile extends UserProfile {

    /**
     * AdminProfile constructor.
     *
     * Copies all data from given $userProfile data
     *
     * @param UserProfile $userProfile
     */
    public function __construct($userProfile) {
        if (is_a($userProfile, "UserProfile")) {
            $this -> data = $userProfile -> data;
            $this -> attributes = $userProfile -> attributes;
        } else {
            return false;
        }
    }

    /**
     * Renames column in 'attributes' table .
     *
     * @param string $attr 'attributes' column name to be changed
     * @param string $newAttr New 'attributes' name
     * @throws Exception if there is an error when executing query, that renames column
     */
    public function renameAttrCol($attr, $newAttr) {
        $conn = self::connect();

        $sql = "ALTER TABLE " . self::attrTable . " CHANGE COLUMN `$attr` `$newAttr` VARCHAR(40) NULL DEFAULT NULL";
        if (!$conn -> query($sql)) {
            throw new Exception("Error, something went wrong renaming attribute!");
        }
        $conn -> close();
    }

    /**
     * Deletes column from table 'attributes' by given name
     *
     * @param string $attr column name to be deleted
     * @throws Exception if there is an error when executing query, that deletes column
     */
    public function delAttrCol($attr) {
        $conn = self::connect();

        $sql = "ALTER TABLE " . self::attrTable . " DROP COLUMN `$attr`";
        if (!$conn -> query($sql)) {
            throw new Exception("Error, something went wrong deleting attribute!");
        }
        $conn -> close();
    }

    /**
     * Adds column to 'attributes' table
     *
     * @param string $colName new column name
     * @throws Exception if there is an error when executing query, that adds column
     */
    public function addAttrCol($colName) {
        $conn = self::connect();

        $sql = "ALTER TABLE " . self::attrTable . " ADD `$colName` VARCHAR(40)";
        if (!$conn -> query($sql)) {
            throw new Exception("Error, something went wrong adding attribute!");
        }
        $conn -> close();
    }
}
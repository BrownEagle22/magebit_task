<?php

/**
 * Validates given data
 *
 * Returns validated data or throws exception, if rules are violated
 */
class Validation {
    /**
     * Maximum input string length
     */
    const maxLen = 50;

    /**
     * Validates data
     *
     * removes unwanted spaces, backslashes and converts html special characters.
     *
     * @param string $key field name, that is being validated
     * @param string $value field value, that is being validated
     * @param bool $checkEmpty shows, if field needs to be empty
     *
     * @return string validated value
     *
     * @throws Exception if value needs to be empty but it isn't
     * @throws Exception if value length is longer than maximum allowed length
     */
    static function validate($key, $value, $checkEmpty = false) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);

        if ($checkEmpty && strlen($value) == 0) {
            throw new Exception("Error, '$key' field can't be empty!");
        }
        if (strlen($value) > self::maxLen) {
            throw new Exception("Error, '$key' field text is too long!");
        }

        return $value;
    }

    /**
     * Validates email
     *
     * Validates email and throws exception, if is doesn't match needed pattern
     *
     * @param string $data email that needs to be validated
     *
     * @return string validated email
     *
     * @throws Exception if email doesn't match neede pattern
     */
    static function validEmail($data) {
        $data = self::validate("email", $data);
        if (!preg_match("/^.+(@)[A-Za-z0-9-]+[\.][A-Za-z]+$/", $data)) {
            throw new Exception("Invalid email!");
        }
        return $data;
    }

    /**
     * Validates password
     *
     * Password isn't changed but only checked if it doesn't violate any rules.
     *
     * @param string $data password, that needs to be validated
     *
     * @return string validated password
     *
     * @throws Exception if password doesn't match needed pattern
     * @throws Exception if password doesn't have needed length
     */
    static function validPassword($data) {
        if (strlen($data) >= 8 && strlen($data) <= self::maxLen) {
            if (preg_match("/^[A-Za-z0-9-?_!@%]+$/", $data)) {
                return $data;
            } else {
                throw new Exception("Invalid password (allowed characters: a-z A-Z 0-9 -?_!@%)");
            }
        } else {
            throw new Exception("Error, password length must be 8-50 !");
        }
    }

    /**
     * Validates user attribute name
     *
     * returns validated attributed name and thows exception, if rules are violated
     *
     * @param string $data attribute name to be validated
     *
     * @return string validated attribute name
     *
     * @throws Exception if attribute name contains unallowed characters
     */
    static function validAttribute($data) {
        $data = self::validate("attribute", $data, true);
        if (strpos($data, ".") || strpos($data, "[") || strpos($data, "_")) {
            throw new Exception("Invalid attribute name, . [ _ not allowed");
        } else {
            return $data;
        }
    }
}
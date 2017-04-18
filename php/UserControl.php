<?php
include ("UserProfile.php");
include ("AdminProfile.php");

/**
 * Allows to get and redirect the current user.
 */
class UserControl {
    /**
     * Array with page names, that is only for guests
     */
    const guestPages = array("index.php", "registerSuccessful.php");
    /**
     * Array with page names, that is not for guests
     */
    const userPages = array("welcome.php", "profile.php", "changePassword.php");
    /**
     * Array with page names, that is only for admins
     */
    const adminPages = array("manage.php");

    /**
     * Returns current user object
     *
     * User id is got from session. Then new user object is created with that id.
     * If user is admin, then is is replaced with admin object.
     *
     * @return AdminProfile|null|UserProfile current user object(null if there is no user)
     */
    public static function getUser() {
        session_start();
        if (!isset($_SESSION["id"])) {
            return null;
        }

        $id = $_SESSION["id"];
        $user = new UserProfile($id);
        if ($user -> isAdmin()) {
            $user = new AdminProfile($user);
        }

        return $user;
    }

    /**
     * Redirects users, if they are in unallowed page.
     *
     * each user type(quest, user, admin) is redirected to their home pages, if they visit unallowed pages.
     *
     * @param AdminProfile|null|UserProfile $user
     * @param string $page Page, where user locates right now.
     */
    public static function redirect($user, $page) {

        if ($user == null && !in_array($page, self::guestPages)) {
            header ("Location: /index.php");
        } else if (!is_a($user, "AdminProfile") && in_array($page, self::adminPages)) {
            header ("Location: /welcome.php");
        } else if (is_a($user, "UserProfile") && in_array($page, self::guestPages)) {
            header ("Location: /welcome.php");
        }
    }
}
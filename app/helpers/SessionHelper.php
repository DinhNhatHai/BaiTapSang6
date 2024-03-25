<?php


class SessionHelper {
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
        
    }

    public static function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public static function logout() {
        unset($_SESSION['user_id']);
    }
}
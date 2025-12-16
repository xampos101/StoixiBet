<?php
/**
 * Authentication Helper
 * Checks if user is logged in as admin
 */
session_start();

function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdmin() {
    if (!isAdmin()) {
        // Determine correct path based on current location
        $loginPath = (strpos($_SERVER['PHP_SELF'], 'Database pages') !== false) ? '../login.php' : 'login.php';
        header('Location: ' . $loginPath);
        exit;
    }
}

function requireLogin() {
    if (!isset($_SESSION['admin_logged_in'])) {
        // Determine correct path based on current location
        $loginPath = (strpos($_SERVER['PHP_SELF'], 'Database pages') !== false) ? '../login.php' : 'login.php';
        header('Location: ' . $loginPath);
        exit;
    }
}



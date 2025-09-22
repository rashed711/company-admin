<?php
// app/helpers/permission_helper.php

/**
 * Check if the logged-in user has a specific permission.
 * Permissions are loaded into the session on login.
 *
 * @param string $slug The permission slug to check for.
 * @return bool True if the user has the permission, false otherwise.
 */
function hasPermission($slug) {
    // First, ensure user is logged in.
    if (!isLoggedIn()) {
        return false;
    }

    // Check if permissions are set in session and if the slug exists.
    if (isset($_SESSION['permissions']) && is_array($_SESSION['permissions'])) {
        return in_array($slug, $_SESSION['permissions']);
    }

    return false; // Default to no permission if session data is missing.
}
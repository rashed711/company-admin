<?php
class Permission {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * Get all effective permission slugs for a user.
     * This combines role permissions and user-specific overrides.
     *
     * @param int $userId
     * @return array An array of permission slugs.
     */
    public function getEffectivePermissionSlugs($userId) {
        // Get user's role
        $this->db->query('SELECT role_id FROM users WHERE id = :user_id');
        $this->db->bind(':user_id', $userId);
        $user = $this->db->single();

        if (!$user || is_null($user->role_id)) {
            return []; // No role, no permissions
        }
        $roleId = $user->role_id;

        // 1. Get permissions from role
        $this->db->query('
            SELECT p.slug FROM permissions p
            JOIN role_permissions rp ON p.id = rp.permission_id
            WHERE rp.role_id = :role_id
        ');
        $this->db->bind(':role_id', $roleId);
        $rolePermissions = $this->db->resultSet();
        $permissions = array_column($rolePermissions, 'slug');

        // 2. Get user-specific 'allow' permissions
        $this->db->query('
            SELECT p.slug FROM permissions p
            JOIN user_permissions up ON p.id = up.permission_id
            WHERE up.user_id = :user_id AND up.type = "allow"
        ');
        $this->db->bind(':user_id', $userId);
        $userAllowPermissions = $this->db->resultSet();
        $permissions = array_merge($permissions, array_column($userAllowPermissions, 'slug'));
        $permissions = array_unique($permissions); // Remove duplicates

        // 3. Get user-specific 'deny' permissions and remove them
        $this->db->query('
            SELECT p.slug FROM permissions p
            JOIN user_permissions up ON p.id = up.permission_id
            WHERE up.user_id = :user_id AND up.type = "deny"
        ');
        $this->db->bind(':user_id', $userId);
        $userDenyPermissions = $this->db->resultSet();
        $denySlugs = array_column($userDenyPermissions, 'slug');

        return array_diff($permissions, $denySlugs);
    }
}
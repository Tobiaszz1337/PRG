<?php

class User extends Model
{
    protected static string $table   = 'users';
    protected static string $primary = 'id';

    /**
     * Find a user by their email address.
     */
    public static function findByEmail(string $email): ?array
    {
        return static::where('email', '=', $email)->first();
    }

    /**
     * Search users by name or email (LIKE query).
     */
    public static function search(string $term): array
    {
        return static::raw(
            'SELECT * FROM `users` WHERE `name` LIKE ? OR `email` LIKE ? ORDER BY `name`',
            ["%{$term}%", "%{$term}%"]
        );
    }
}

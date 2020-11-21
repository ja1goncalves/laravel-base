<?php


namespace App\Util;


use phpDocumentor\Reflection\Types\Self_;

final class UserRoleEnum
{
    public const ADMIN = 'admin';
    public const EDITOR = 'editor';
    public const PUBLIC = 'public';
    public const CLIENT = 'client';

    private const ROLES = [
        self::ADMIN => 'Administrador',
        self::EDITOR => 'Editor',
        self::PUBLIC => 'Público',
        self::CLIENT => 'Cliente'
    ];

    public static function roles(): array
    {
      return self::ROLES;
    }

    public static function getUserRoles(string $role): string
    {
        return array_key_exists($role, self::ROLES)
            ? self::ROLES[$role]
            : 'Cliente';
    }
}

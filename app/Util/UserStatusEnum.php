<?php


namespace App\Util;


final class UserStatusEnum
{
    private const INACTIVE = 0;
    private const ACTIVE = 1;
    private const BLOCKED = 2;
    private const SUSPENDED = 3;

    private const NAMES = ['Inativo', 'Ativo', 'Bloqueado', 'Suspenso'];

    public static function getName(int $status): string
    {
        return array_key_exists($status, self::NAMES)
            ? self::NAMES[$status]
            : '';
    }

    /**
     * @param int $status
     * @return bool
     */
    public static function acceptableStatus(int $status): bool
    {
        return in_array($status, [self::ACTIVE]);
    }
}

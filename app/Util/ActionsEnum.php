<?php


namespace App\Util;


final class ActionsEnum
{
    private const INDEX = 'index';
    private const SHOW = 'show';
    private const STORE = 'store';
    private const UPDATE = 'update';
    private const DELETE = 'delete';

    private const NAMES = [
        'index' => 'Inicio',
        'show' => 'Ler',
        'store' => 'Criar',
        'update' => 'Atualizar',
        'delete' => 'Remover',
    ];

    private const ACTIONS = ['index', 'show', 'store', 'update', 'delete'];

    public static function getName(int $action): string
    {
        return array_key_exists($action, self::NAMES)
            ? self::NAMES[$action]
            : '';
    }
    public static function getActions(): array
    {
        return self::ACTIONS;
    }
}

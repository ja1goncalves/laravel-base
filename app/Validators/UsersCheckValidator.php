<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UsersCheckValidator.
 *
 * @package namespace App\Validators;
 */
class UsersCheckValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
//          'users_id' => 'required|numeric|exist:users,id',
//          'start' => 'required|date',
//          'end' => 'sometimes|nullable|date',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}

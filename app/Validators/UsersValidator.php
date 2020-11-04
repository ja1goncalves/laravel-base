<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UsersValidator.
 *
 * @package namespace App\Validators;
 */
class UsersValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
      ValidatorInterface::RULE_CREATE => [
        'name'      => 'required|string|min:5|max:120',
        'email'     => 'required|string|email|max:150',
        'password'  => 'required|string',
        'status'    => 'sometimes|integer',
        'role'      => 'sometimes|string|min:5|max:50'
      ],
      ValidatorInterface::RULE_UPDATE => [],
    ];
}

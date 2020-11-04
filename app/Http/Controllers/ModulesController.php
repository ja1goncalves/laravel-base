<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CrudMethods;
use App\Http\Requests\ModulesCreateRequest;
use App\Http\Requests\ModulesUpdateRequest;
use App\Services\ModulesService;
use App\Validators\ModulesValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ModulesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ModulesController extends Controller
{
  use CrudMethods {
    store as generalStore;
    update as generalUpdate;
  }

  /**
   * @var ModulesService
   */
  protected $service;

  /**
   * @var ModulesValidator
   */
  protected $validator;

  /**
   * UsersController constructor.
   *
   * @param ModulesService $service
   * @param ModulesValidator $validator
   */
  public function __construct(ModulesService $service, ModulesValidator $validator)
  {
    $this->service = $service;
    $this->validator  = $validator;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  ModulesCreateRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Prettus\Validator\Exceptions\ValidatorException
   */
  public function store(ModulesCreateRequest $request)
  {
    return $this->generalStore($request);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param ModulesUpdateRequest $request
   * @param string $id
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws ValidatorException
   */
  public function update(ModulesUpdateRequest $request, $id)
  {
    return $this->generalUpdate($request, $id);
  }
}

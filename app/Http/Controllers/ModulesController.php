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
   * @param ModulesService $services
   * @param ModulesValidator $validator
   */
  public function __construct(ModulesService $services, ModulesValidator $validator)
  {
    $this->service = $services;
    $this->validator  = $validator;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
   */
  public function index()
  {
    $modules = $this->service->all()['data'];
    $breadcrumbs = [
      ['link'=>"dashboard-analytics",'name'=>"Início"],
      ['link'=>"dashboard-analytics",'name'=>"Páginas"],
      ['name'=>"Lista de Módulos"]
    ];

    if (request()->wantsJson()) {
      return response()->json(['data' => $modules]);
    }

    return view('/pages/modules/index', compact('modules', 'breadcrumbs'));
  }

  /**
   * Show the form for add the specified resource.
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
   */
  public function add()
  {
    $breadcrumbs = [
      ['link'=>"dashboard-analytics",'name'=>"Início"],
      ['link'=>"dashboard-analytics",'name'=>"Páginas"],
      ['name'=>"Adicionar módulo"]
    ];

    return view('/pages/modules/add', compact('breadcrumbs'));
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  ModulesCreateRequest $request
   *
   * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
   */
  public function store(ModulesCreateRequest $request)
  {
    try {
      $module = $this->service->create($request->all())['data'];

      if ($request->wantsJson())
        return response()->json(['message' => 'Modules created.', 'data' => $module]);

      return redirect("/modules/edit/".$module['id'])->with('message', 'Módulo atualizado!');
    } catch (\Exception $e) {
      if ($request->wantsJson())
        return response()->json(['error' => true, 'message' => $e->getMessage()]);

      return redirect()->back()->withErrors($e->getMessage())->withInput();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
   */
  public function show(int $id)
  {
    $module = $this->service->find($id)['data'];
    $breadcrumbs = [
      ['link'=>"dashboard-analytics",'name'=>"Início"],
      ['link'=>"dashboard-analytics",'name'=>"Páginas"],
      ['name'=>"Visualização de módulo"]
    ];

    if (request()->wantsJson()) {
      return response()->json([
        'data' => $module,
      ]);
    }

    return view('/pages/modules/show', compact('module', 'breadcrumbs'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
   */
  public function edit(int $id)
  {
    $module = $this->service->find($id)['data'];

    $breadcrumbs = [
      ['link'=>"dashboard-analytics",'name'=>"Início"],
      ['link'=>"dashboard-analytics",'name'=>"Páginas"],
      ['name'=>"Edição de módulo"]
    ];

    return view('/pages/modules/edit', compact('module', 'breadcrumbs'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param ModulesUpdateRequest $request
   * @param string $id
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  public function update(ModulesUpdateRequest $request, string $id)
  {
    try {
      $module = $this->service->update($request->all(), $id);

      if ($request->wantsJson()) {
        return response()->json(['message' => 'Module updated.', 'data' => $module->toArray()]);
      }

      return redirect("/modules/edit/$id")->with('message', 'Usuário atualizado!');
    } catch (\Exception $e) {
      if ($request->wantsJson()) {
        return response()->json(['error' => true, 'message' => $e->getMessage()]);
      }

      return redirect()->back()->withErrors($e->getMessage())->withInput();
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
   */
  public function destroy(int $id)
  {
    $deleted = $this->service->delete($id);

    if (request()->wantsJson())
      return response()->json(['message' => 'Module deleted.', 'deleted' => $deleted]);

    return redirect('/users');
  }
}

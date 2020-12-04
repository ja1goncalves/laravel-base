<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UsersCheckCreateRequest;
use App\Http\Requests\UsersCheckUpdateRequest;
use App\Services\UsersCheckService;
use App\Validators\UsersCheckValidator;

/**
 * Class UsersChecksController.
 *
 * @package namespace App\Http\Controllers;
 */
class UsersChecksController extends Controller
{
    /**
     * @var UsersCheckService
     */
    protected $service;

    /**
     * @var UsersCheckValidator
     */
    protected $validator;

    /**
     * UsersChecksController constructor.
     *
     * @param UsersCheckService $service
     * @param UsersCheckValidator $validator
     */
    public function __construct(UsersCheckService $service, UsersCheckValidator $validator)
    {
        $this->service = $service;
        $this->validator  = $validator;
    }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
   */
  public function index()
  {
    $checks = $this->service->all();

    $breadcrumbs = [
      ['link'=>"dashboard-analytics",'name'=>"Início"],
      ['link'=>"dashboard-analytics",'name'=>"Páginas"],
      ['name'=>"Checagem"]
    ];

    if (request()->wantsJson()) return response()->json(['data' => $checks]);

    return view('/pages/check/index', compact('checks', 'breadcrumbs'));
  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
   */
  public function everyone(Request $request)
  {
    $checks = $this->service->everyone($request->get('at', ''));

    $breadcrumbs = [
      ['link'=>"dashboard-analytics",'name'=>"Início"],
      ['link'=>"dashboard-analytics",'name'=>"Páginas"],
      ['name'=>"Checagem"]
    ];

    if (request()->wantsJson()) return response()->json(['data' => $checks]);

    return view('/pages/check/everyone', compact('checks', 'breadcrumbs'));
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
      ['name'=>"Adicionar Checagem"]
    ];

    return view('/pages/check/add', compact('breadcrumbs'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   *
   * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
   */
  public function store(UsersCheckCreateRequest $request)
  {
    try {
      $check = $this->service->create($request->all())['data'];

      if ($request->wantsJson()) return response()->json(['message' => 'Check created.', 'data' => $check]);

      return redirect("/checks")->with('message', 'Checagem atualizada!');
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
    $check = $this->service->find($id)['data'];
    $breadcrumbs = [
      ['link'=>"dashboard-analytics",'name'=>"Início"],
      ['link'=>"dashboard-analytics",'name'=>"Páginas"],
      ['name'=>"Visualização de cheacagem"]
    ];

    if (request()->wantsJson()) return response()->json(['data' => $check]);

    return view('/pages/check/show', compact('check', 'breadcrumbs'));
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
    $check = $this->service->find($id)['data'];

    $breadcrumbs = [
      ['link'=>"dashboard-analytics",'name'=>"Início"],
      ['link'=>"dashboard-analytics",'name'=>"Páginas"],
      ['name'=>"Edição de Chegagem"]
    ];

    return view('/pages/check/edit', compact('check', 'breadcrumbs'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UsersCheckUpdateRequest $request
   * @param string $id
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  public function update(UsersCheckUpdateRequest $request, string $id)
  {
    try {
      $check = $this->service->update($id);

      if ($request->wantsJson()) {
        return response()->json(['message' => 'Check updated.', 'data' => $check->toArray()]);
      }

      return redirect("/checks")->with('message', 'Checagem atualizada!');
    } catch (\Exception $e) {
      if ($request->wantsJson()) {
        return response()->json(['error' => true, 'message' => $e->getMessage()]);
      }

      return redirect()->back()->withErrors($e->getMessage())->withInput();
    }
  }
}

<?php

namespace App\Http\Controllers;

use App\Util\UserRoleEnum;
use App\Util\UserStatusEnum;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Services\UsersService;
use App\Validators\UsersValidator;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class UsersController extends Controller
{
    /**
     * @var UsersService
     */
    protected $service;

    /**
     * @var UsersValidator
     */
    protected $validator;

    /**
     * UsersController constructor.
     *
     * @param UsersService $services
     * @param UsersValidator $validator
     */
    public function __construct(UsersService $services, UsersValidator $validator)
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
        $users = $this->service->all()['data'];
        $breadcrumbs = [
          ['link'=>"dashboard-analytics",'name'=>"Início"],
          ['link'=>"dashboard-analytics",'name'=>"Páginas"],
          ['name'=>"Lista de usuários"]
        ];

        if (request()->wantsJson()) {
            return response()->json(['data' => $users]);
        }

        return view('/pages/users/index', compact('users', 'breadcrumbs'));
    }

    /**
     * Show the form for add the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function add()
    {
      $status = UserStatusEnum::status();
      $roles = UserRoleEnum::roles();

      $breadcrumbs = [
        ['link'=>"dashboard-analytics",'name'=>"Início"],
        ['link'=>"dashboard-analytics",'name'=>"Páginas"],
        ['name'=>"Adicionar usuário"]
      ];

      return view('/pages/users/add', compact('status', 'roles', 'breadcrumbs'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  UsersCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(UsersCreateRequest $request)
    {
        try {
            $user = $this->service->create($request->all())['data'];

            if ($request->wantsJson())
                return response()->json(['message' => 'Users created.', 'data' => $user]);

          return redirect("/users/edit/".$user['id'])->with('message', 'Usuário atualizado!');
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
        $data = $this->service->find($id);
        $user = $data['user']['data'];
        $hours = $data['hours'];
        $points = $data['points'];
        $breadcrumbs = [
          ['link'=>"dashboard-analytics",'name'=>"Início"],
          ['link'=>"dashboard-analytics",'name'=>"Páginas"],
          ['name'=>"Visualização de usuários"]
        ];

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $user,
            ]);
        }

        return view('/pages/users/show', compact('user', 'hours', 'points', 'breadcrumbs'));
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
        $user = $this->service->find($id)['data'];
        $status = UserStatusEnum::status();
        $roles = UserRoleEnum::roles();

        $breadcrumbs = [
          ['link'=>"dashboard-analytics",'name'=>"Início"],
          ['link'=>"dashboard-analytics",'name'=>"Páginas"],
          ['name'=>"Edição de usuários"]
        ];

        return view('/pages/users/edit', compact('user', 'status', 'roles', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UsersUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(UsersUpdateRequest $request, string $id)
    {
        try {
            $user = $this->service->update($request->all(), $id);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Users updated.', 'data' => $user->toArray()]);
            }

          return redirect("/users/edit/$id")->with('message', 'Usuário atualizado!');
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
            return response()->json(['message' => 'Users deleted.', 'deleted' => $deleted,]);

        return redirect('/users');
    }

    public function updateUserModule(Request $request, $id)
    {
        return $this->service->updateUserModule($id);
    }

    public function updateUserModuleAction(Request $request, $id)
    {
        return $this->service->updateUserModuleAction($id);
    }
}

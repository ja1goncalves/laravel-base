<?php

namespace App\Http\Controllers;

use App\Util\UserRoleEnum;
use App\Util\UserStatusEnum;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
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
     * Store a newly created resource in storage.
     *
     * @param  UsersCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UsersCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->service->create($request->all());

            $response = [
                'message' => 'Users created.',
                'data'    => $user->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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
        $user = $this->service->find($id)['data'];
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

        return view('/pages/users/show', compact('user', 'breadcrumbs'));
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
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => true, 'message' => $e->getMessageBag()]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Users deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Users deleted.');
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

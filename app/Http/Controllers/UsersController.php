<?php

namespace App\Http\Controllers;

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
    protected $services;

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
        $this->services = $services;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->services->all()['data'];
        $breadcrumbs = [
          ['link'=>"dashboard-analytics",'name'=>"Home"],
          ['link'=>"dashboard-analytics",'name'=>"Pages"],
          ['name'=>"User List"]
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

            $user = $this->repository->create($request->all());

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
        $user = $this->services->find($id)['data'];
        $breadcrumbs = [
          ['link'=>"dashboard-analytics",'name'=>"Home"],
          ['link'=>"dashboard-analytics",'name'=>"Pages"],
          ['name'=>"User View"]
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
        $user = $this->services->find($id);
        $breadcrumbs = [
          ['link'=>"dashboard-analytics",'name'=>"Home"],
          ['link'=>"dashboard-analytics",'name'=>"Pages"],
          ['name'=>"User Edit"]
        ];

        return view('/pages/users/edit', compact('user','breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UsersUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UsersUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $user = $this->services->update($request->all(), $id);

            $response = [
                'message' => 'Users updated.',
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->services->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Users deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Users deleted.');
    }
}

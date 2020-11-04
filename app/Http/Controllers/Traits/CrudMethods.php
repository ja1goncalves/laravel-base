<?php
/**
 * Created by PhpStorm.
 * User: raylison
 * Date: 01/02/19
 * Time: 10:40
 */

namespace App\Http\Controllers\Traits;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Http\Request;
use App\Services\AppService;

/**
 * Class CrudMethods
 * @package app\Http\Controllers\Traits
 */
trait CrudMethods
{
    /** @var  AppService $service */
    protected $service;

    /** @var  ValidatorInterface $validator */
    protected $validator;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->service->all($request->query->get('limit', 15)));
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json($this->service->find($id));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ValidatorException
     */
    public function store(Request $request)
    {
        try {
            return response()->json($this->service->create($request->all()));
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error'   => true,
                'message' => $e->getMessage(),
                'status' => 500
            ]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws ValidatorException
     */
    public function update(Request $request, $id)
    {
        try {
            return response()->json($this->service->update($request->all(), $id));
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error'   => true,
                'message' => $e->getMessage(),
                'status' => 500
            ]);
        }
    }

    /**
     * Softdeletes the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        return response()->json($this->service->delete($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->delete($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findWhere(array $data)
    {
        return response()->json($this->service->findWhere($data));
    }

}

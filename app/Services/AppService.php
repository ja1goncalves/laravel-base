<?php

namespace App\Services;

use Prettus\Repository\Contracts\RepositoryInterface;
use App\Util\Functions;
use Carbon\Carbon;

/**
 * Class AppService
 * @package App\Services
 * @method all($get)
 * @method create(array $all)
 * @method find(int $id)
 * @method update(array $all, $id)
 * @method delete($id)
 * @method findWhere(array $data)
 */
class AppService
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @param array|object $data
     * @param string $message
     * @param int $status
     * @return array
     */
    protected function returnSuccess($data = [], $message = 'Everything OK!', $status = 200)
    {
        return [
            'data' => is_array($data) ? $this->setValueNull($data) : $data,
            'error' => false,
            'message' => $message,
            'status' => $status
        ];
    }

    /**
     * @param array|object $data
     * @param string $message
     * @param int $status
     * @return array
     */
    protected function returnError($data = [], $message = 'Any error occurrence!', $status = 500)
    {
        return [
            'data' => is_array($data) ? $this->setValueNull($data) : $data,
            'error' => true,
            'message' => $message,
            'status' => $status
        ];
    }

    /**
     * @param array $data
     * @return array|bool|int|string
     */
    protected function setValueNull($data = [])
    {
        if (is_bool($data) || $data === 0) return $data;
        if (is_null($data)) return '';
        if ((is_string($data) && strtotime($data) !== false)) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $data)->format('d/m/Y H:i:s');
        }

        $return = [];
        if (!empty($data)):
            if (is_array($data) || is_object($data)):
                foreach ($data as $key => $item) :
                    if (in_array($key, Functions::DATES_TIME, true)):
                        $item = str_replace('T', ' ', substr($item, 0, 19));
                    endif;
                    $return[$key] = $this->setValueNull($item);
                endforeach;
            else:
                return is_null($data) ? '' : $data;
            endif;
        endif;

        return $return;
    }
}

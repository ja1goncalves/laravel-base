<?php

namespace App\Presenters;

use App\Transformers\UsersCheckTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UsersCheckPresenter.
 *
 * @package namespace App\Presenters;
 */
class UsersCheckPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UsersCheckTransformer();
    }
}

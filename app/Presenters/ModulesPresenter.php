<?php

namespace App\Presenters;

use App\Transformers\ModulesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ModulesPresenter.
 *
 * @package namespace App\Presenters;
 */
class ModulesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ModulesTransformer();
    }
}

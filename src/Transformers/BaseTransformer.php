<?php
/**
 * Creator htm
 * Created by 2020/11/4 15:53.
 **/

namespace Szkj\Rbac\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return $data->toArray();
    }
}

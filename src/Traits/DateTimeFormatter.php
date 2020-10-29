<?php
/**
 * Creator htm
 * Created by 2020/10/28 17:06
 **/

namespace Szkj\Rbac\Traits;


trait DateTimeFormatter
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
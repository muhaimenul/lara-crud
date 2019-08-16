<?php

/**
 * Created by PhpStorm.
 * User: Muhaimenul Islam
 * Date: 8/16/2019
 * Time: 6:49 PM
 */
namespace Muhaimenul\Laracrud\Services;

class CrudGenerator
{
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    
}
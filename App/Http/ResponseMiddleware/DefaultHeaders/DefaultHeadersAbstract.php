<?php
namespace App\Http\ResponseMiddleware\DefaultHeaders;

use Config\DefaultHeaders as ConfigDefaultHeaders;

abstract class DefaultHeadersAbstract{


    public function __construct(
        protected ConfigDefaultHeaders $config
    )
    {
        
    }
}
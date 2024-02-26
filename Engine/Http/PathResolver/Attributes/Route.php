<?php
namespace Engine\Http\PathResolver\Attributes;

use Attribute;

#[Attribute]
class Route{


    public function __construct(
        public readonly string $routePath,
        public readonly string $routeMethod
        ) {
    }
}



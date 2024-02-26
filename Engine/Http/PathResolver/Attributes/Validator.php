<?php
namespace Engine\Http\PathResolver\Attributes;

use Attribute;

#[Attribute]
class Validator{


    public function __construct(
        public readonly string $validatorClass,
        ) {
    }
}



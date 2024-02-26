<?php
namespace Engine\Http;

use Engine\Http\Request\RequestInterface;

interface RequestFlowInterface
{

    public function getFlow(RequestInterface $request): array;
}

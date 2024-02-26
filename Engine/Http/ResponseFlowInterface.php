<?php
namespace Engine\Http;

use Engine\Http\Request\RequestInterface;
use Engine\Http\Response\ResponseInterface;

interface ResponseFlowInterface
{

    public function getFlow(ResponseInterface $request): array;
}

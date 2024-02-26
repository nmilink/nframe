<?php

namespace Engine\DB;

use Closure;
use Config\MySqlConfig;
use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestChainInterface;
use Engine\Http\Response\Response;
use Engine\Http\Response\ResponseInterface;
use Exception;
use mysqli;

class MysqlConnection implements DBConnectionInterface, RequestChainInterface
{

    protected mysqli|null $connection = null;

    public function __construct(
        protected MySqlConfig $config
    ) {
        $this->connect();
    }
    protected function connect()
    {
        try {
            $this->connection = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->dbName);
        } catch (Exception $e) {
            $this->connection = null;
        }
    }
    public function getConnection(): mysqli|null
    {
        if (is_null($this->connection)) {
            $this->connect();
        }
        return $this->connection;
    }

    public function handle(RequestInterface $request, Closure $next): ResponseInterface
    {
        $connection = $this->getConnection();
        if (is_null($connection) || $connection->connect_error) {
            $response = new Response();
            $response->setStatusCode(500);
            $response->setData([
                'success' => false,
                'error' => 'DB_error'
            ]);
            return $response;
        }
        return $next($request);
    }
}

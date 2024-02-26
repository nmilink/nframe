<?php

namespace Engine\Http\Response;



class Response implements ResponseInterface{
    protected array $data;
    protected array $headers;
    protected int $code;

    public function setData(array $data):Response{
        $this->data = $data;
        return $this;
    }

    public function setHeader(string $key, string $value):Response{
        $this->headers[$key] = $value;
        return $this;
    }
    public function setStatusCode(int $statusCode):Response{
        $this->code = $statusCode;
        return $this;
    }

    public function formResponse(){
        http_response_code($this->code);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        echo \json_encode($this->data);
    }
}
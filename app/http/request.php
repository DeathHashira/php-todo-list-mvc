<?php namespace App\Http;

class Request
{
    public array $params;
    public string $method;
    public string $uri;

    public function __construct(array $params = [])
    {
        $this->method = $this->getMethod();
        $this->uri = $this->uri();
        $this->params = $params;
    }

    private function uri() : string
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    private function getMethod() : string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

}
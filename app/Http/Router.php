<?php

namespace App\Http;

use Closure;
use Exception;

class Router
{
    private string $url = '';
    private string $prefix = '';
    private array $routes = [];
    private $request;


    public function __construct(string $url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    private function setPrefix(): void
    {
        $parseUrl = parse_url($this->url);

        //Define o prefixo
        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute(string $method, string $route, array $params = []): void
    {

        foreach($params as $key=>$value) {
            if($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        $this->routes[$patternRoute][$method] = $params;
    }


    public function get(string $route, array $params = []): void
    {
        $this->addRoute('GET', $route, $params);
    }

    public function post(string $route, array $params = []): void
    {
        $this->addRoute('POST', $route, $params);
    }

    public function put(string $route, array $params = []): void
    {
        $this->addRoute('PUT', $route, $params);
    }

    public function delete(string $route, array $params = []): void
    {
        $this->addRoute('DELETE', $route, $params);
    }


    private function getUri(): string
    {
        $uri = $this->request->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);
    }


    private function getRoute()
    {
        $uri = $this->getUri();

        $httpMethod = $this->request->getHttpMethod();

        foreach($this->routes as $patternRoute=>$methods) {
            if(preg_match($patternRoute, $uri)) {
                if($methods[$httpMethod]) {
                    return $methods[$httpMethod];
                }

                throw new Exception("Método não permitido", 405);
            }
        }

        throw new Exception("Url não encontrada", 404);
    }

    public function run(): Response
    {
        try {

            $route = $this->getRoute();
            if(!isset($route['controller'])) {
                throw new Exception("URL não pode ser processada", 500);
            }

            $args = [];
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

}

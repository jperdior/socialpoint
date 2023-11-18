<?php

namespace SP\Infrastructure\Http;
use \SP\Infrastructure\Kernel as KernelInterface;
use \SP\Infrastructure\Request as RequestInterface;
use \SP\Infrastructure\Response as ResponseInterface;
use SP\Application\Router\Router;

class Kernel implements KernelInterface {

    public static function createWithDataSet(array $dataset): static {
        return new static($dataset);
    }
    private function __construct(private array $dataset) {
        // TODO: it's mandatory to bootstrap this application so that the data used is the one provided in the dataset :D
    }

    public function run(RequestInterface $request): ResponseInterface {

        $router = new Router();
        $callable = $router->match($request->getMethod(), $request->getUri());
        if ($callable === null) {
            return new Response(404, 'Not Found');
        }
        return $callable($request, $this->dataset);
    }
}

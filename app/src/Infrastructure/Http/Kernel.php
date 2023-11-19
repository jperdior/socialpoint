<?php

namespace SP\Infrastructure\Http;

use DI\ContainerBuilder;
use DI\Container;
use \SP\Infrastructure\Kernel as KernelInterface;
use \SP\Infrastructure\Request as RequestInterface;
use \SP\Infrastructure\Response as ResponseInterface;
use SP\Application\Router\Router;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use SP\Infrastructure\Data\DatasetStorage;

class Kernel implements KernelInterface {

    private Container $container;

    public static function createWithDataSet(array $dataset): static {
        return new static($dataset);
    }

    private function __construct(private array $dataset)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            SerializerInterface::class => $serializer
        ]);
        $this->container = $containerBuilder->build();
        DatasetStorage::updateDataset($this->dataset);
    }

    public function run(RequestInterface $request): ResponseInterface {

        $router = new Router();
        $routerMatch = $router->match($request->getMethod(), $request->getUri());
        if ($routerMatch === null) {
            return new Response(404, 'Not Found');
        }
        $params = array_merge([
            $request, ...$routerMatch->params
        ]);
        return $this->container->call($routerMatch->controller, $params);
    }
}

<?php

namespace SP\Infrastructure\Http;

use DI\ContainerBuilder;
use DI\Container;
use SP\Infrastructure\Data\Redis\RedisClient;
use \SP\Infrastructure\Kernel as KernelInterface;
use \SP\Infrastructure\Request as RequestInterface;
use \SP\Infrastructure\Response as ResponseInterface;
use SP\Application\Router\Router;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use SP\Infrastructure\Data\DatasetStorage;
use function DI\create;

class Kernel implements KernelInterface {

    private Container $container;

    public static function createWithDataSet(array $dataset): static {
        return new static($dataset);
    }

    private function __construct(private array $dataset)
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($this->initializeDefinitions());
        $this->container = $containerBuilder->build();
        $this->initializeDataset($this->dataset);
    }

    private function initializeDefinitions(): array
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return [
            SerializerInterface::class => $serializer,
            RedisClient::class => create(RedisClient::class)
                ->constructor(
                    host: 'redis',
                    port: 6379,
                    password: 'password'
                ),
        ];
    }

    private function initializeDataset(array $dataset): void
    {
        $redisClient = $this->container->get(RedisClient::class);

        $redisClient->initializeDataset('user', $dataset);

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

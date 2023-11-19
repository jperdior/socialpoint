<?php

namespace SP\Infrastructure\Http;
use DI\Container;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use SP\Domain\Repository\UserRepositoryInterface;
use SP\Infrastructure\Data\Repository\UserRepository;
use \SP\Infrastructure\Kernel as KernelInterface;
use \SP\Infrastructure\Request as RequestInterface;
use \SP\Infrastructure\Response as ResponseInterface;
use SP\Application\Router\Router;
use function DI\create;

class Kernel implements KernelInterface {

    private Container $container;

    public static function createWithDataSet(array $dataset): static {
        return new static($dataset);
    }

    private function __construct(private array $dataset)
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('/var/log/social_point.log', Level::Warning));
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            UserRepositoryInterface::class => create(UserRepository::class)
        ]);
        $this->container = $containerBuilder->build();
        $this->container->set('dataset', $this->dataset);
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

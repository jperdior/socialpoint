<?php

declare(strict_types=1);

namespace SP\Infrastructure\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use SP\Domain\Logging\LoggerInterface;

class SocialPointLogger implements LoggerInterface
{

    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger('socialpoint');
        $this->logger->pushHandler(new StreamHandler('php://stdout', Level::Debug));
    }

    public function info(string $message): void
    {
        $this->logger->info($message);
    }

    public function error(string $message): void
    {
        $this->logger->error($message);
    }

    public function warning(string $message): void
    {
        $this->logger->warning($message);
    }


}
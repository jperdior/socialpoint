<?php

declare(strict_types=1);

namespace SP\Application\Command;

use SP\Domain\Entity\User;
use SP\Domain\Exception\UserNotFoundException;
use SP\Domain\Logging\LoggerInterface;
use SP\Domain\UseCase\User\ModifyAbsoluteScoreUseCase;
use SP\Domain\UseCase\User\ModifyRelativeScoreUseCase;

readonly class ModifyScoreMessageHandler
{
    public function __construct(
        private ModifyAbsoluteScoreUseCase $modifyAbsoluteScoreUseCase,
        private ModifyRelativeScoreUseCase $modifyRelativeScoreUseCase,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function handle(ModifyScoreMessage $message): User
    {
        try {
            switch ($message->operation) {
                case 'absolute':
                    $this->logger->info('Modifying absolute score for user ' . $message->userId . ' by ' . $message->score);
                    return $this->modifyAbsoluteScoreUseCase->execute($message->userId, $message->score);
                case 'relative':
                    $this->logger->info('Modifying relative score for user ' . $message->userId . ' by ' . $message->score);
                    return $this->modifyRelativeScoreUseCase->execute($message->userId, $message->score);
                default:
                    $this->logger->error('Invalid operation');
                    throw new \Exception('Invalid operation');
            }
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw $exception;
        }

    }


}

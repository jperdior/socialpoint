<?php

declare(strict_types=1);

namespace SP\Application\Query;

use SP\Domain\Entity\User;
use SP\Domain\Exception\UserNotFoundException;
use SP\Domain\Logging\LoggerInterface;
use SP\Domain\UseCase\User\GetAbsoluteRankingUseCase;
use SP\Domain\UseCase\User\GetRelativeRankingUseCase;
use SP\Domain\UseCase\User\ModifyAbsoluteScoreUseCase;
use SP\Domain\UseCase\User\ModifyRelativeScoreUseCase;

readonly class GetRankingMessageHandler
{

    public function __construct(
        private GetAbsoluteRankingUseCase $getAbsoluteRankingUseCase,
        private GetRelativeRankingUseCase $getRelativeRankingUseCase,
        private LoggerInterface $logger
    ){
    }

    /**
     * @throws UserNotFoundException
     * @throws \Exception
     */
    public function handle(GetRankingMessage $message): array
    {
        try{
            preg_match('/top(\d+)/i', $message->type, $matches);
            if (!empty($matches[1])) {
                $top = (int)$matches[1];
                $this->logger->info('Getting absolute ranking for top ' . $top);
                return $this->getAbsoluteRankingUseCase->execute($top);
            }
            if (preg_match('/^At(\d+)\/(\d+)$/', $message->type, $atMatches)) {
                $this->logger->info('Getting relative ranking for user ' . $atMatches[1] . ' at ' . $atMatches[2]);
                return $this->getRelativeRankingUseCase->execute((int)$atMatches[1], (int)$atMatches[2]);
            }
            $this->logger->error('Invalid type');
            throw new \Exception('Invalid type');
        }
        catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
            throw $exception;
        }

    }


}


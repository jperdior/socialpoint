<?php

declare(strict_types=1);

namespace SP\Application\Query;

use SP\Domain\Entity\User;
use SP\Domain\Exception\UserNotFoundException;
use SP\Domain\UseCase\User\GetAbsoluteRankingUseCase;
use SP\Domain\UseCase\User\GetRelativeRankingUseCase;
use SP\Domain\UseCase\User\ModifyAbsoluteScoreUseCase;
use SP\Domain\UseCase\User\ModifyRelativeScoreUseCase;

class GetRankingMessageHandler
{

    public function __construct(
        private readonly GetAbsoluteRankingUseCase $getAbsoluteRankingUseCase,
        private readonly GetRelativeRankingUseCase $getRelativeRankingUseCase,
    ){
    }

    /**
     * @throws UserNotFoundException
     */
    public function handle(GetRankingMessage $message): array
    {
        try{
            preg_match('/top(\d+)/i', $message->type, $matches);
            if (!empty($matches[1])) {
                $top = (int)$matches[1];
                return $this->getAbsoluteRankingUseCase->execute($top);
            }
            if (preg_match('/^At(\d+)\/(\d+)$/', $message->type, $atMatches)) {
                return $this->getRelativeRankingUseCase->execute((int)$atMatches[1], (int)$atMatches[2]);
            }
        }
        catch (\Exception $exception){
            throw $exception;
        }

    }


}


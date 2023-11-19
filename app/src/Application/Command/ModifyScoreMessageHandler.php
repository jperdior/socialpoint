<?php

declare(strict_types=1);

namespace SP\Application\Command;

use SP\Domain\Exception\UserNotFoundException;
use SP\Domain\UseCase\User\ModifyAbsoluteScoreUseCase;
use SP\Domain\UseCase\User\ModifyRelativeScoreUseCase;

class ModifyScoreMessageHandler
{

    public function __construct(
        private readonly ModifyAbsoluteScoreUseCase $modifyAbsoluteScoreUseCase,
        private readonly ModifyRelativeScoreUseCase $modifyRelativeScoreUseCase
    ){
    }

    /**
     * @throws UserNotFoundException
     */
    public function handle(ModifyScoreMessage $message): void
    {
        try{
            switch ($message->operation) {
                case 'absolute':
                    $this->modifyAbsoluteScoreUseCase->execute($message->userId, $message->score);
                    break;
                case 'relative':
                    $this->modifyRelativeScoreUseCase->execute($message->userId, $message->score);
                    break;
            }
        }
        catch (\Exception $exception){
            throw $exception;
        }

    }


}


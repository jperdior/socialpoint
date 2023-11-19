<?php

declare(strict_types=1);

namespace SP\Application\Command;

use SP\Domain\Entity\User;
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
    public function handle(ModifyScoreMessage $message): User
    {
        try{
            switch ($message->operation) {
                case 'absolute':
                    return $this->modifyAbsoluteScoreUseCase->execute($message->userId, $message->score);
                case 'relative':
                    return $this->modifyRelativeScoreUseCase->execute($message->userId, $message->score);
            }
        }
        catch (\Exception $exception){
            throw $exception;
        }

    }


}


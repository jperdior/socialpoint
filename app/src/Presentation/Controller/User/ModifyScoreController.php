<?php

declare(strict_types=1);

namespace SP\Presentation\Controller\User;

use SP\Application\Command\ModifyScoreMessage;
use SP\Application\Command\ModifyScoreMessageHandler;
use SP\Domain\Entity\User;
use SP\Infrastructure\Request;
use SP\Infrastructure\Http\Response;
use SP\Presentation\Controller\AbstractController;
use SP\Presentation\Validator\User\ModifyScoreValidator;

class ModifyScoreController extends AbstractController
{

    public function __construct(
        private readonly ModifyScoreValidator $validator,
        private readonly ModifyScoreMessageHandler $commandHandler
    ){
    }

    public function __invoke(
        Request $request,
        string $userId
    ): Response
    {
        $body = json_decode($request->getBody(), true);
        try{
            $this->validator->validate($body);
        }
        catch (\Exception $exception){
            return new Response(
                statusCode: 400,
                body: $exception->getMessage()
            );
        }

        $total = $body['total'] ?? null;
        $score = $body['score'] ?? null;

        try{
            $userResult = new User(
                id: $userId
            );
            $this->commandHandler->handle(new ModifyScoreMessage(
                userId: $userId,
                operation: $total ? 'absolute' : 'relative',
                score: $score ?? $total ?? 0
            ));
            return new Response(
                statusCode: 200,
                body: $this->serializer->serialize($userResult, 'json')
            );
        }
        catch (\Exception $exception){
            return new Response(
                statusCode: 500,
                body: $exception->getMessage()
            );
        }


    }

}
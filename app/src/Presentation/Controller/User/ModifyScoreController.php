<?php

declare(strict_types=1);

namespace SP\Presentation\Controller\User;

use SP\Application\Command\ModifyScoreMessage;
use SP\Application\Command\ModifyScoreMessageHandler;
use SP\Infrastructure\Request;
use SP\Infrastructure\Http\Response;
use SP\Presentation\Controller\AbstractController;
use SP\Presentation\Validator\User\ModifyScoreValidator;
use Symfony\Component\Serializer\SerializerInterface;

class ModifyScoreController extends AbstractController
{

    public function __construct(
        private readonly ModifyScoreValidator $validator,
        private readonly ModifyScoreMessageHandler $commandHandler,
        private readonly SerializerInterface $serializer
    ){
    }

    public function __invoke(
        Request $request,
        string $userId
    ): Response
    {
        $body = json_decode($request->getBody(), true);
        $errors = $this->validator->validate($body);
        if (count($errors) > 0) {
            return new Response(
                statusCode: 400,
                body: $this->serializer->serialize($errors, 'json')
            );
        }

        $total = $body['total'] ?? null;
        $score = $body['score'] ?? null;

        try{
            $user = $this->commandHandler->handle(new ModifyScoreMessage(
                userId: $userId,
                operation: $total ? 'absolute' : 'relative',
                score: $score ?? $total ?? 0
            ));

            return new Response(
                statusCode: 200,
                body: $this->serializer->serialize($user, 'json')
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
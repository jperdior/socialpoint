<?php

declare(strict_types=1);

namespace SP\Presentation\Controller\User;

use SP\Application\Query\GetRankingMessage;
use SP\Application\Query\GetRankingMessageHandler;
use SP\Infrastructure\Http\Response;
use SP\Infrastructure\Request;
use SP\Presentation\Controller\AbstractController;
use SP\Presentation\Validator\User\GetRankingValidator;
use Symfony\Component\Serializer\SerializerInterface;

class GetRankingController extends AbstractController
{

    public function __construct(
        private readonly GetRankingValidator $validator,
        private readonly GetRankingMessageHandler $queryHandler,
        private readonly SerializerInterface $serializer
    )
    {
    }

    public function __invoke(
        Request $request
    ): Response
    {
        $params = $request->getParameters();
        $errors = $this->validator->validate($params);
        if (count($errors) > 0) {
            return new Response(
                statusCode: 400,
                body: $this->serializer->serialize($errors, 'json')
            );
        }
        $top = $params['type'];
        try{
            $ranking = $this->queryHandler->handle(new GetRankingMessage(
                type: $top
            ));

            return new Response(
                statusCode: 200,
                body: $this->serializer->serialize(['data'=>$ranking], 'json')
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
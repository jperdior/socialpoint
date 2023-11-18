<?php
declare(strict_types=1);

use SP\Infrastructure\Http\Kernel;
use SP\Infrastructure\Http\Request;

require '../vendor/autoload.php';
require '../data/dataset/dataset.php';

$kernel = Kernel::createWithDataSet(rankingDataSet());
$request = createRequestFromGlobals();
$response = $kernel->run($request);

http_response_code($response->getStatusCode());
echo $response->getBody();

function createRequestFromGlobals(): Request
{
    $rawMethod = $_SERVER['REQUEST_METHOD'];
    return new Request(
        explode('?', $_SERVER['REQUEST_URI'])[0],
        $rawMethod,
        $_REQUEST,
        file_get_contents('php://input')
    );
}

exit;

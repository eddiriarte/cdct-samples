<?php
/**
 * Created by PhpStorm.
 * User: eiriarte-mendez
 * Date: 07.05.19
 * Time: 00:13
 */

namespace EddIriarte\Consumer\Action;


use Slim\Http\Request;
use Slim\Http\Response;

class SetAppStateForContractVerification
{

    public function __invoke(Request $request, Response $response)
    {
        $payload = $request->getParsedBody();
        file_put_contents(
            APP_ROOT . '/provider-state.log',
            var_export($payload, true),
            \FILE_APPEND
        );


        return $response->withJson(null, 200);
    }

}
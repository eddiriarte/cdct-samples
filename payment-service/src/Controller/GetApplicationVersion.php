<?php

namespace EddIriarte\Payment\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetApplicationVersion
{
    public function __invoke()
    {
        return new JsonResponse(
            'Payment Service (1.0.0) powered by Symfony'
        );
    }
}

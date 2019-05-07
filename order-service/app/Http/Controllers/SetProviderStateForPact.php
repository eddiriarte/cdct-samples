<?php

namespace EddIriarte\Order\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;

class SetProviderStateForPact extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json(null, 200);
    }
}

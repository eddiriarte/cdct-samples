<?php


namespace App\Http\Controllers;


use App\Services\Clients\CustomerApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

class LogIn extends \Laravel\Lumen\Routing\Controller
{
    private CustomerApiClient $customerApi;

    public function __construct(CustomerApiClient $customerApi)
    {
        $this->customerApi = $customerApi;
    }

    public function __invoke(Request $request)
    {
        try {
            $user = $this->customerApi->login($request['username']);

            $hash = Hash::make($user->toJson());

            Cache::put($hash, $user->toJson());

            $cookie = new Cookie('auth', $hash);

            return redirect('/orders')->withCookie($cookie);
        } catch (\Exception $exception) {
            return redirect('/')
                ->with([
                    'error' => 'Login failed!',
                    'messages' => [
                        $exception->getMessage(),
                    ],
                ]);
        }
    }
}

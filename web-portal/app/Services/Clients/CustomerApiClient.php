<?php


namespace App\Services\Clients;


use App\Domain\Auth\AuthenticatedUser;
use App\Exceptions\AuthenticationRequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerApiClient
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function login(string $username): AuthenticatedUser
    {
        $response = null;
        try {
            $response = Http::post($this->baseUrl . '/api/v1/auth', ['username' => $username]);
        } catch (\Exception $exception) {
            throw new AuthenticationRequestException($exception->getMessage());
        }

        if ($response->failed()) {
            Log::warning(json_encode($response->json()));
            throw new AuthenticationRequestException('An error occurred!');
        }

        return AuthenticatedUser::make($response->json('data'));
    }
}

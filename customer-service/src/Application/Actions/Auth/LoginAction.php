<?php

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Domain\Customer\CustomerRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class LoginAction extends Action
{
    /**
     * @var CustomerRepository
     */
    protected $userRepository;

    /**
     * @param LoggerInterface $logger
     * @param CustomerRepository $userRepository
     */
    public function __construct(LoggerInterface $logger,
                                CustomerRepository $userRepository
    ) {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }

    protected function action(): Response
    {
        $inputs = $this->getFormData();

        $user = $this->userRepository->findCustomerByUsername($inputs->username);

        $this->logger->info("Customer `{$user->getUsername()}` was authenticated.");

        return $this->respondWithData($user);
    }
}
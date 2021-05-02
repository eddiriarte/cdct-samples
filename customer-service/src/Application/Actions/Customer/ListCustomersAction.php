<?php
declare(strict_types=1);

namespace App\Application\Actions\Customer;

use Psr\Http\Message\ResponseInterface as Response;

class ListCustomersAction extends CustomerAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->userRepository->findAll();

        $this->logger->info("Users list was viewed.");

        return $this->respondWithData($users);
    }
}

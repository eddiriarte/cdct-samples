<?php
declare(strict_types=1);

namespace App\Application\Actions\Customer;

use Psr\Http\Message\ResponseInterface as Response;

class ViewCustomerAction extends CustomerAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->userRepository->findCustomerById($userId);

        $this->logger->info("Customer of id `${userId}` was viewed.");

        return $this->respondWithData($user);
    }
}

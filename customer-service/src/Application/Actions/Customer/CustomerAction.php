<?php
declare(strict_types=1);

namespace App\Application\Actions\Customer;

use App\Application\Actions\Action;
use App\Domain\Customer\CustomerRepository;
use Psr\Log\LoggerInterface;

abstract class CustomerAction extends Action
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
}

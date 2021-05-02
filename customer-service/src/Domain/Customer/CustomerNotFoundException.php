<?php
declare(strict_types=1);

namespace App\Domain\Customer;

use App\Domain\DomainException\DomainRecordNotFoundException;

class CustomerNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}

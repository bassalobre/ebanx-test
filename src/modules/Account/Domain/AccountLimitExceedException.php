<?php

namespace Source\Modules\Account\Domain;

class AccountLimitExceedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Account limit exceed.', 406);
    }
}

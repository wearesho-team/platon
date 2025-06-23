<?php

declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Payment;

interface PayerDetails
{
    public int $agreementNumber {
        get;
    }
    public string $taxNumber {
        get;
    }
}

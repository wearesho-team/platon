<?php
// phpcs:ignoreFile PHPCS doesn't support interface properties yet (3.13)
declare(strict_types=1);

namespace Wearesho\Bobra\Platon\Credit\Transfer;

interface RecipientInformation
{
    public int $agreementNumber {
        get;
    }
    public string $taxNumber {
        get;
    }
    public string $firstName {
        get;
    }
    public string $lastName {
        get;
    }
}

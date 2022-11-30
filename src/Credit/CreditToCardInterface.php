<?php

namespace Wearesho\Bobra\Platon\Credit;

use Wearesho\Bobra\Payments\Credit;

interface CreditToCardInterface extends Credit\TransferInterface
{
    public const ACTION_CARD = 'CREDIT2CARD';
    public const ACTION_TOKEN = 'CREDIT2CARDTOKEN';
}

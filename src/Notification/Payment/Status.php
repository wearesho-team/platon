<?php

namespace Wearesho\Bobra\Platon\Notification\Payment;

interface Status
{
    public const SALE = 'SALE';
    public const REFUND = 'REFUND';
    public const DEBIT = 'DEBIT';
    public const CHARGEBACK = 'CHARGEBACK';
}

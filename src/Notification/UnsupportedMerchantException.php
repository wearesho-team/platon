<?php

namespace Wearesho\Bobra\Platon\Notification;

/**
 * Class UnsupportedMerchantException
 * @package Wearesho\Bobra\IPay\Notification
 */
class UnsupportedMerchantException extends \RuntimeException
{
    /** @var int */
    protected $merchantKey;

    public function __construct(string $merchantKey, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct("Unsupported MerchantId $merchantKey", $code, $previous);
        $this->merchantKey = $merchantKey;
    }

    public function getMerchantKey(): int
    {
        return $this->merchantKey;
    }
}

<?php

namespace Wearesho\Bobra\Platon\Notification;

use Wearesho\Bobra\Platon\Notification\Payment\Status;

/**
 * Interface PaymentInterface
 * @package Wearesho\Bobra\Platon\Notification
 */
interface PaymentInterface
{
    public function getId(): string;

    public function getKey(): string;

    public function getOrderId(): string;

    /**
     * @return string
     * @see Status
     */
    public function getStatus(): string;

    public function getAmount(): float;

    public function getCurrency(): string;

    public function getCard(): string;

    public function getDate(): \DateTimeInterface;

    public function getData(): array;
}

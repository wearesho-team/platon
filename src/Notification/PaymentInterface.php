<?php

namespace Wearesho\Bobra\Platon\Notification;

/**
 * Interface PaymentInterface
 * @package Wearesho\Bobra\Platon\Notification
 */
interface PaymentInterface
{
    public function getId(): string;

    public function getOrderId(): string;

    public function getStatus(): string;

    public function getAmount(): float;

    public function getCurrency(): string;

    public function getCard(): string;

    public function getDate(): string;

    public function getData(): array;
}

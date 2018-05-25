<?php

namespace Wearesho\Bobra\Platon\Notification;

/**
 * Class Payment
 * @package Wearesho\Bobra\Platon\Notification
 */
class Payment implements PaymentInterface
{
    public const STATUS_SALE = 'SALE';
    public const STATUS_REFUND = 'REFUND';
    public const STATUS_CHARGEBACK = 'CHARGEBACK';

    /** @var string */
    protected $id;

    /** @var string */
    protected $orderId;

    /** @var float */
    protected $amount;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $status;

    /** @var string */
    protected $card;

    /** @var string */
    protected $date;

    /** @var array */
    protected $data;

    public function __construct(
        string $id,
        string $orderId,
        float $amount,
        string $currency,
        string $status,
        string $card,
        string $date,
        array $data = []
    ) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->status = $status;
        $this->card = $card;
        $this->date = $date;
        $this->data = $data;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCard(): string
    {
        return $this->card;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
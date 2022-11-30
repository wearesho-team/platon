<?php

namespace Wearesho\Bobra\Platon;

use Wearesho\Bobra\Payments;

class LanguageTransaction extends Transaction implements Payments\HasLanguage
{
    use LanguageConfigTrait;

    public function __construct(
        int $service,
        float $amount,
        string $type,
        string $description,
        array $info = [],
        string $currency = 'UAH',
        string $formId = null,
        string $language = ConfigInterface::LANGUAGE_UA
    ) {
        parent::__construct($service, $amount, $type, $description, $info, $currency, $formId);
        $this->setLanguage($language);
    }
}

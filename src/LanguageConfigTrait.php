<?php

namespace Wearesho\Bobra\Platon;

/**
 * Trait LanguageConfigTrait
 * @package Wearesho\Bobra\Platon
 */
trait LanguageConfigTrait
{
    use ValidateLanguage;

    protected string $language = ConfigInterface::LANGUAGE_UA;

    /**
     * @inheritdoc
     * @see ConfigInterface::getLanguage()
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->validateLanguage($language);
        $this->language = $language;

        return $this;
    }
}

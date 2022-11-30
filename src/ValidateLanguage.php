<?php

namespace Wearesho\Bobra\Platon;

trait ValidateLanguage
{
    /**
     * @param string $language
     * @throws \InvalidArgumentException
     */
    protected function validateLanguage(string $language): void
    {
        $isLanguageValid = $language === ConfigInterface::LANGUAGE_UA
            || $language === ConfigInterface::LANGUAGE_RU;

        if (!$isLanguageValid) {
            throw new \InvalidArgumentException("Invalid language");
        }
    }
}

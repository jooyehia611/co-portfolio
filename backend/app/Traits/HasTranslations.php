<?php

namespace App\Traits;

use App\Support\Translator;

trait HasTranslations
{
    public function translate(string $field, ?string $locale = null): mixed
    {
        return Translator::get($this->getAttribute($field), $locale);
    }
}

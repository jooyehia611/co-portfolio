<?php

namespace Database\Seeders\Concerns;

trait Bilingual
{
    protected function t(string $ar, string $en): array
    {
        return ['ar' => $ar, 'en' => $en];
    }
}

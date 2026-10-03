<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TranslationCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null || $value === '') {
            return ['ar' => '', 'en' => ''];
        }

        if (is_array($value)) {
            return $this->normalize($value);
        }

        $decoded = json_decode((string) $value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $this->normalize($decoded);
        }

        return ['ar' => (string) $value, 'en' => (string) $value];
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return json_encode($this->normalize($decoded), JSON_UNESCAPED_UNICODE);
            }

            return json_encode(['ar' => $value, 'en' => $value], JSON_UNESCAPED_UNICODE);
        }

        if (is_array($value)) {
            return json_encode($this->normalize($value), JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['ar' => (string) $value, 'en' => (string) $value], JSON_UNESCAPED_UNICODE);
    }

    private function normalize(array $value): array
    {
        return [
            'ar' => $value['ar'] ?? $value['en'] ?? '',
            'en' => $value['en'] ?? $value['ar'] ?? '',
        ];
    }
}

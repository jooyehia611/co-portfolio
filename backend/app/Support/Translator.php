<?php

namespace App\Support;

class Translator
{
    public static function get(mixed $value, ?string $locale = null): mixed
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        if ($value === null) {
            return '';
        }

        if (is_array($value)) {
            if (self::isTranslationMap($value)) {
                return $value[$locale]
                    ?? $value[$fallback]
                    ?? $value['ar']
                    ?? $value['en']
                    ?? '';
            }

            return array_map(fn ($item) => self::get($item, $locale), $value);
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return self::get($decoded, $locale);
            }
        }

        return $value;
    }

    public static function mergeFromRequest(array $data, array $fields): array
    {
        foreach ($fields as $field) {
            $ar = $data["{$field}_ar"] ?? null;
            $en = $data["{$field}_en"] ?? null;

            if ($ar !== null || $en !== null) {
                $data[$field] = [
                    'ar' => $ar ?? $en ?? '',
                    'en' => $en ?? $ar ?? '',
                ];
                unset($data["{$field}_ar"], $data["{$field}_en"]);
            }
        }

        return $data;
    }

    public static function splitForForm(mixed $value): array
    {
        if (is_array($value) && self::isTranslationMap($value)) {
            return ['ar' => $value['ar'] ?? '', 'en' => $value['en'] ?? ''];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return self::splitForForm($decoded);
            }

            return ['ar' => $value, 'en' => $value];
        }

        return ['ar' => '', 'en' => ''];
    }

    public static function translateContent(mixed $content, ?string $locale = null): mixed
    {
        if (! is_array($content)) {
            return $content;
        }

        $result = [];
        foreach ($content as $key => $value) {
            if (is_array($value) && self::isTranslationMap($value)) {
                $result[$key] = self::get($value, $locale);
            } elseif (is_array($value)) {
                $result[$key] = self::translateContent($value, $locale);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    private static function isTranslationMap(array $value): bool
    {
        $keys = array_keys($value);

        return count(array_intersect($keys, ['ar', 'en'])) > 0
            && count($keys) <= 3;
    }
}

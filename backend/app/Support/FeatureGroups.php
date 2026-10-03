<?php

namespace App\Support;

class FeatureGroups
{
    public static function forForm(mixed $keyFeatures): array
    {
        if (! is_array($keyFeatures) || $keyFeatures === []) {
            return [];
        }

        if (self::isGroupList($keyFeatures)) {
            return collect($keyFeatures)
                ->map(fn (array $group) => [
                    'title' => Translator::splitForForm($group['title'] ?? null),
                    'points' => collect($group['points'] ?? [])
                        ->map(fn ($point) => Translator::splitForForm($point))
                        ->values()
                        ->all(),
                ])
                ->values()
                ->all();
        }

        if (array_key_exists('points', $keyFeatures) || array_key_exists('title', $keyFeatures)) {
            return [[
                'title' => Translator::splitForForm($keyFeatures['title'] ?? null),
                'points' => collect($keyFeatures['points'] ?? [])
                    ->map(fn ($point) => Translator::splitForForm($point))
                    ->values()
                    ->all(),
            ]];
        }

        return [[
            'title' => ['ar' => '', 'en' => ''],
            'points' => collect($keyFeatures)
                ->map(fn ($point) => Translator::splitForForm($point))
                ->values()
                ->all(),
        ]];
    }

    public static function parseRequest(array $groups): ?array
    {
        $result = [];

        foreach ($groups as $group) {
            $titleAr = trim((string) ($group['title_ar'] ?? ''));
            $titleEn = trim((string) ($group['title_en'] ?? ''));
            $hasTitle = $titleAr !== '' || $titleEn !== '';

            $points = [];
            foreach ($group['points'] ?? [] as $point) {
                $ar = trim((string) ($point['ar'] ?? ''));
                $en = trim((string) ($point['en'] ?? ''));

                if ($ar === '' && $en === '') {
                    continue;
                }

                $points[] = [
                    'ar' => $ar !== '' ? $ar : $en,
                    'en' => $en !== '' ? $en : $ar,
                ];
            }

            if (! $hasTitle && $points === []) {
                continue;
            }

            $result[] = [
                'title' => $hasTitle ? [
                    'ar' => $titleAr !== '' ? $titleAr : $titleEn,
                    'en' => $titleEn !== '' ? $titleEn : $titleAr,
                ] : null,
                'points' => $points,
            ];
        }

        return $result === [] ? null : $result;
    }

    public static function forApi(mixed $keyFeatures): ?array
    {
        if (! is_array($keyFeatures) || $keyFeatures === []) {
            return null;
        }

        if (self::isGroupList($keyFeatures)) {
            return collect($keyFeatures)
                ->map(function (array $group) {
                    $points = collect($group['points'] ?? [])
                        ->map(fn ($point) => Translator::get($point))
                        ->filter()
                        ->values()
                        ->all();

                    $title = Translator::get($group['title'] ?? null);

                    if ($title === '' && $points === []) {
                        return null;
                    }

                    return [
                        'title' => $title !== '' ? $title : null,
                        'points' => $points,
                    ];
                })
                ->filter()
                ->values()
                ->all() ?: null;
        }

        if (array_key_exists('points', $keyFeatures) || array_key_exists('title', $keyFeatures)) {
            $single = self::forApi([$keyFeatures]);

            return $single;
        }

        $points = collect($keyFeatures)
            ->map(fn ($point) => Translator::get($point))
            ->filter()
            ->values()
            ->all();

        if ($points === []) {
            return null;
        }

        return [[
            'title' => null,
            'points' => $points,
        ]];
    }

    private static function isGroupList(array $keyFeatures): bool
    {
        return array_is_list($keyFeatures)
            && isset($keyFeatures[0])
            && is_array($keyFeatures[0])
            && (array_key_exists('points', $keyFeatures[0]) || array_key_exists('title', $keyFeatures[0]));
    }
}

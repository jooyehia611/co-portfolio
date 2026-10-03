<?php

/**
 * Safe fill: only INSERT missing settings / UPDATE empty homepage fields.
 * Never deletes or overwrites existing non-empty dashboard data.
 */

use App\Models\HomepageSection;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

function bilingual(string $ar, string $en): string
{
    return json_encode(['ar' => $ar, 'en' => $en], JSON_UNESCAPED_UNICODE);
}

function isEmptyMixed(mixed $value): bool
{
    if ($value === null || $value === '') {
        return true;
    }
    if (is_string($value)) {
        $decoded = json_decode($value, true);
        if (is_array($decoded) && array_key_exists('ar', $decoded) && array_key_exists('en', $decoded)) {
            return trim((string) ($decoded['ar'] ?? '')) === '' && trim((string) ($decoded['en'] ?? '')) === '';
        }

        return trim($value) === '';
    }
    if (is_array($value)) {
        if (array_key_exists('ar', $value) || array_key_exists('en', $value)) {
            return trim((string) ($value['ar'] ?? '')) === '' && trim((string) ($value['en'] ?? '')) === '';
        }

        return $value === [];
    }

    return false;
}

DB::transaction(function () {
    $settingsToEnsure = [
        [
            'key' => 'view_all_label',
            'group' => 'ui',
            'type' => 'text',
            'value' => bilingual('عرض الكل', 'View all'),
        ],
        [
            'key' => 'explore_label',
            'group' => 'ui',
            'type' => 'text',
            'value' => bilingual('استكشف', 'Explore'),
        ],
        [
            'key' => 'projects_count_label',
            'group' => 'ui',
            'type' => 'text',
            'value' => bilingual('مشاريع', 'Projects'),
        ],
        [
            'key' => 'services_label',
            'group' => 'ui',
            'type' => 'text',
            'value' => bilingual('الخدمات', 'Services'),
        ],
    ];

    foreach ($settingsToEnsure as $row) {
        $existing = Setting::where('key', $row['key'])->first();
        if (! $existing) {
            Setting::create($row);
            echo "INSERT setting {$row['key']}\n";
            continue;
        }
        if (isEmptyMixed($existing->value)) {
            $existing->update(['value' => $row['value'], 'group' => $row['group'], 'type' => $row['type']]);
            echo "FILL setting {$row['key']}\n";
        } else {
            echo "KEEP setting {$row['key']}\n";
        }
    }

    $sectionFills = [
        'services' => [
            'subtitle' => bilingual('خدماتنا', 'Our Services'),
        ],
        'business_values' => [
            'subtitle' => bilingual('القيمة', 'Value'),
        ],
        'process' => [
            'subtitle' => bilingual('المنهج', 'Method'),
            'content.description' => bilingual(
                'مسار واضح من تحديد المشكلة إلى الإطلاق — بدون تعقيد زائد.',
                'A clear path from problem framing to production — without theatre.'
            ),
        ],
        'testimonials' => [
            'subtitle' => bilingual('آراء العملاء', 'Testimonials'),
        ],
        'insights' => [
            'subtitle' => bilingual('المدونة', 'Insights'),
        ],
        'cta' => [
            'content.eyebrow' => bilingual('الخطوة التالية', 'Next brief'),
        ],
        'hero' => [
            'content.panel_eyebrow' => bilingual('قدراتنا', 'Capabilities'),
            'content.panel_title' => bilingual('ما نبنيه', 'What we build'),
        ],
    ];

    foreach ($sectionFills as $key => $fills) {
        $section = HomepageSection::where('section_key', $key)->first();
        if (! $section) {
            echo "MISSING section {$key}\n";
            continue;
        }

        $dirty = false;
        $content = is_array($section->content) ? $section->content : [];

        foreach ($fills as $field => $value) {
            if (str_starts_with($field, 'content.')) {
                $contentKey = substr($field, 8);
                $current = $content[$contentKey] ?? null;
                if (isEmptyMixed($current)) {
                    $content[$contentKey] = json_decode($value, true);
                    $dirty = true;
                    echo "FILL {$key}.content.{$contentKey}\n";
                } else {
                    echo "KEEP {$key}.content.{$contentKey}\n";
                }
                continue;
            }

            $current = $section->{$field} ?? null;
            if (isEmptyMixed($current)) {
                $section->{$field} = json_decode($value, true);
                $dirty = true;
                echo "FILL {$key}.{$field}\n";
            } else {
                echo "KEEP {$key}.{$field}\n";
            }
        }

        if ($dirty) {
            $section->content = $content;
            $section->save();
        }
    }
});

echo "Done.\n";

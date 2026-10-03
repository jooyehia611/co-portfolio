<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeoPageResource;
use App\Models\SeoPage;
use App\Models\Setting;
use App\Support\Translator;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function privacy(): JsonResponse
    {
        $raw = Setting::where('key', 'privacy_content')->value('value');
        $content = Translator::get($raw) ?: Translator::get($this->defaultPrivacy());

        $seo = SeoPage::where('page_key', 'privacy')->first();

        return response()->json([
            'success' => true,
            'data' => [
                'title' => __('pages.privacy_title'),
                'content' => $content,
                'seo' => $seo ? (new SeoPageResource($seo))->toArray(request()) : null,
            ],
        ]);
    }

    public function terms(): JsonResponse
    {
        $raw = Setting::where('key', 'terms_content')->value('value');
        $content = Translator::get($raw) ?: Translator::get($this->defaultTerms());

        $seo = SeoPage::where('page_key', 'terms')->first();

        return response()->json([
            'success' => true,
            'data' => [
                'title' => __('pages.terms_title'),
                'content' => $content,
                'seo' => $seo ? (new SeoPageResource($seo))->toArray(request()) : null,
            ],
        ]);
    }

    private function defaultPrivacy(): array
    {
        return [
            'ar' => '<p>تحترم Ytech خصوصيتك. نجمع معلومات الاتصال فقط للرد على استفسارات المشاريع وتقديم خدماتنا. لا نبيع البيانات الشخصية لأطراف ثالثة.</p><p>للاستفسارات حول التعامل مع البيانات، تواصل معنا على hello@ytech.com.</p>',
            'en' => '<p>Ytech respects your privacy. We collect contact information solely to respond to project inquiries and deliver our services. We do not sell personal data to third parties.</p><p>For questions about data handling, contact us at hello@ytech.com.</p>',
        ];
    }

    private function defaultTerms(): array
    {
        return [
            'ar' => '<p>باستخدامك لموقع وخدمات Ytech، فإنك توافق على شروط التعاقد القياسية لدينا. يتم تحديد نطاق المشروع والجداول الزمنية والمخرجات في اتفاقيات عمل فردية.</p><p>يتم تحديد جميع شروط الملكية الفكرية في اتفاقية المشروع.</p>',
            'en' => '<p>By using the Ytech website and services, you agree to our standard engagement terms. Project scope, timelines, and deliverables are defined in individual statements of work.</p><p>All intellectual property terms are specified per project agreement.</p>',
        ];
    }
}

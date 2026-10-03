import { AudioLines } from 'lucide-react';
import { useLocaleData } from '@/hooks/useLocaleData';
import { useI18n } from '@/i18n';
import { usePageSeo } from '@/hooks/usePageSeo';
import { fetchTestimonials } from '@/services/testimonialsService';
import { SEOHead } from '@/components/ui/SEOHead';
import { PageHeader } from '@/components/ui/PageHeader';
import { LoadingSpinner } from '@/components/ui/LoadingSpinner';
import { VoiceTestimonialsGrid } from '@/features/home/VoiceTestimonialsSection';

export function ReviewsPage() {
  const { t } = useI18n();
  const { data, loading: dataLoading } = useLocaleData(fetchTestimonials);
  const {
    seo,
    title,
    description,
    loading: seoLoading,
  } = usePageSeo('reviews', {
    title: t('reviews.title'),
    description: t('reviews.description'),
  });
  const voices = data?.filter((item) => item.audio_url) ?? [];

  if (dataLoading || seoLoading) return <LoadingSpinner />;

  return <>
    <SEOHead seo={seo} title={title} description={description} />
    <PageHeader title={title} description={description} crumbs={[{ label: t('reviews.breadcrumb') }]} />
    <section className="voice-testimonials voice-testimonials--archive section-space" aria-label={title}>
      <div className="container-site">
        {voices.length > 0 ? <>
          <div className="voice-testimonials__archive-intro">
            <span><AudioLines size={19} aria-hidden="true" /> {t('reviews.eyebrow')}</span>
            <p>{t('reviews.count')} <strong>{voices.length}</strong></p>
          </div>
          <VoiceTestimonialsGrid testimonials={voices} />
        </> : <div className="voice-testimonials__empty">
          <AudioLines size={38} aria-hidden="true" />
          <h2>{data ? t('reviews.emptyTitle') : t('common.loadFailed')}</h2>
          {data && <p>{t('reviews.emptyDescription')}</p>}
        </div>}
      </div>
    </section>
  </>;
}

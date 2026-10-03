import { useI18n } from '@/i18n';
import { SEOHead } from '@/components/ui/SEOHead';
import { Button } from '@/components/ui/Button';
import { SplitReveal } from '@/components/ui/SplitReveal';

export function NotFoundPage() {
  const { t, localizedPath } = useI18n();

  return (
    <>
      <SEOHead title={`404 — ${t('common.notFound')}`} />

      <section className="page-section">
        <div className="yt-stripes" aria-hidden />
        <div className="container-site not-found">
          <p className="not-found__code">404</p>
          <SplitReveal as="h1" className="not-found__title">
            {t('common.notFound')}
          </SplitReveal>
          <p className="not-found__text">{t('common.notFoundDesc')}</p>
          <div className="not-found__actions">
            <Button href={localizedPath('/')}>{t('common.goHome')}</Button>
          </div>
        </div>
      </section>
    </>
  );
}

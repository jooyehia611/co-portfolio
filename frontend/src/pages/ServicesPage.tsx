import { fetchServices } from '@/services/servicesService';
import { useLocaleData } from '@/hooks/useLocaleData';
import { useI18n } from '@/i18n';
import { usePageSeo } from '@/hooks/usePageSeo';
import { SEOHead } from '@/components/ui/SEOHead';
import { LoadingSpinner } from '@/components/ui/LoadingSpinner';
import { PageHeader } from '@/components/ui/PageHeader';
import { ServiceCard } from '@/features/home/ServiceCard';

export function ServicesPage() {
  const { t } = useI18n();
  const { data: services, loading: servicesLoading } = useLocaleData(fetchServices);
  const {
    seo,
    title,
    description,
    loading: seoLoading,
  } = usePageSeo('services', {
    title: t('services.indexTitle'),
    description: t('services.indexDescription'),
  });

  if (servicesLoading || seoLoading) return <LoadingSpinner />;

  return (
    <>
      <SEOHead seo={seo} title={title} description={description} />

      <PageHeader
        title={title}
        description={description}
        crumbs={[{ label: t('nav.services') }]}
      />

      <section className="page-section section-space">
        <div className="container-site">
          {!services || services.length === 0 ? (
            <p className="empty-state">{t('common.loadFailed')}</p>
          ) : (
            <div className="services-index-grid">
              {services.map((service, index) => (
                <ServiceCard key={service.id} service={service} index={index} />
              ))}
            </div>
          )}
        </div>
      </section>
    </>
  );
}

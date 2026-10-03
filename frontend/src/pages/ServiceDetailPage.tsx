import { Link, useParams } from 'react-router-dom';
import { Check, ChevronRight } from 'lucide-react';
import { fetchService } from '@/services/servicesService';
import { useLocaleData } from '@/hooks/useLocaleData';
import { useServicesList } from '@/hooks/useServicesList';
import { useI18n } from '@/i18n';
import { SEOHead } from '@/components/ui/SEOHead';
import { LoadingSpinner } from '@/components/ui/LoadingSpinner';
import { PageHeader } from '@/components/ui/PageHeader';
import { SectionTitle } from '@/components/ui/SectionTitle';
import { Button } from '@/components/ui/Button';
import { ProjectCard } from '@/components/ui/ProjectCard';
import { cn } from '@/utils/cn';

export function ServiceDetailPage() {
  const { slug } = useParams<{ slug: string }>();
  const { t, localizedPath } = useI18n();
  const allServices = useServicesList();
  const { data: service, loading } = useLocaleData(
    () => fetchService(slug!),
    [slug],
  );

  if (loading) return <LoadingSpinner />;
  if (!service) {
    return <div className="empty-state">{t('common.loadFailed')}</div>;
  }

  const cover = service.cover?.url;

  return (
    <>
      <SEOHead seo={service.seo} title={`${service.title} — Ytech`} />

      <PageHeader
        title={service.title}
        description={service.short_description}
        crumbs={[{ label: t('nav.services'), path: '/services' }, { label: service.title }]}
        backgroundUrl={cover}
      />

      <section className="page-section section-space">
        <div className="container-site">
          <div className="service-detail__layout">
            <div>
              {cover && (
                <div className="service-detail__image">
                  <img src={cover} alt={service.cover?.alt_text || service.title} />
                </div>
              )}

              <h2 className="project-detail__block-title">{t('services.overview')}</h2>
              <div className="project-detail__prose">
                <p>{service.full_description || service.short_description}</p>
              </div>

              {service.capabilities && service.capabilities.length > 0 && (
                <div className="project-detail__block">
                  <h2 className="project-detail__block-title">{t('services.capabilities')}</h2>
                  <ul className="service-detail__capabilities">
                    {service.capabilities.map((item) => (
                      <li key={item}>
                        <Check size={17} />
                        {item}
                      </li>
                    ))}
                  </ul>
                </div>
              )}

              {service.business_problems && service.business_problems.length > 0 && (
                <div className="project-detail__block">
                  <h2 className="project-detail__block-title">{t('services.problems')}</h2>
                  <ul className="project-detail__list">
                    {service.business_problems.map((item) => (
                      <li key={item}>
                        <Check size={17} />
                        {item}
                      </li>
                    ))}
                  </ul>
                </div>
              )}
            </div>

            <aside>
              <ul className="service-nav-list">
                {allServices.map((item) => (
                  <li key={item.slug}>
                    <Link
                      to={localizedPath(`/services/${item.slug}`)}
                      className={cn(item.slug === service.slug && 'is-active')}
                    >
                      {item.title}
                      <ChevronRight size={16} />
                    </Link>
                  </li>
                ))}
              </ul>

              <div className="service-aside-cta">
                <h3 className="service-aside-cta__title">{t('services.askTitle')}</h3>
                <p className="service-aside-cta__text">{t('services.askText')}</p>
                <Button href={localizedPath('/contact')} variant="light">
                  {t('services.askCta')}
                </Button>
              </div>
            </aside>
          </div>
        </div>
      </section>

      {service.related_projects && service.related_projects.length > 0 && (
        <section className="page-section section-space related-strip">
          <div className="container-site">
            <SectionTitle tagline={t('projects.indexLabel')} title={t('services.relatedWork')} />
            <div className="grid-3">
              {service.related_projects.map((project) => (
                <ProjectCard project={project} key={project.id} />
              ))}
            </div>
          </div>
        </section>
      )}
    </>
  );
}

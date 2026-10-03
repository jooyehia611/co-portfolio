import { useLocaleData } from '@/hooks/useLocaleData';
import { fetchProjects } from '@/services/projectsService';
import { useI18n } from '@/i18n';
import { usePageSeo } from '@/hooks/usePageSeo';
import { SEOHead } from '@/components/ui/SEOHead';
import { LoadingSpinner } from '@/components/ui/LoadingSpinner';
import { PageHeader } from '@/components/ui/PageHeader';
import { ProjectCard } from '@/components/ui/ProjectCard';

export function ProjectsPage() {
  const { t } = useI18n();
  const { data: projects, loading: projectsLoading } = useLocaleData(() => fetchProjects());
  const {
    seo,
    title,
    description,
    loading: seoLoading,
  } = usePageSeo('projects', {
    title: t('projects.indexTitle'),
    description: t('projects.indexDescription'),
  });

  if (projectsLoading || seoLoading) return <LoadingSpinner />;

  return (
    <>
      <SEOHead seo={seo} title={title} description={description} />

      <PageHeader
        title={title}
        description={description}
        crumbs={[{ label: t('nav.work') }]}
      />

      <section className="page-section section-space">
        <div className="container-site">
          {!projects || projects.length === 0 ? (
            <p className="empty-state">{t('common.loadFailed')}</p>
          ) : (
            <div className="grid-3">
              {projects.map((project) => (
                <ProjectCard project={project} key={project.id} />
              ))}
            </div>
          )}
        </div>
      </section>
    </>
  );
}

import { useParams } from 'react-router-dom';
import { Check, ExternalLink } from 'lucide-react';
import { fetchProject } from '@/services/projectsService';
import { useLocaleData } from '@/hooks/useLocaleData';
import { useI18n } from '@/i18n';
import { SEOHead } from '@/components/ui/SEOHead';
import { LoadingSpinner } from '@/components/ui/LoadingSpinner';
import { PageHeader } from '@/components/ui/PageHeader';
import { SectionTitle } from '@/components/ui/SectionTitle';
import { Button } from '@/components/ui/Button';
import { ProjectCard } from '@/components/ui/ProjectCard';

export function ProjectDetailPage() {
  const { slug } = useParams<{ slug: string }>();
  const { t } = useI18n();
  const { data: project, loading } = useLocaleData(() => fetchProject(slug!), [slug]);

  if (loading) return <LoadingSpinner />;
  if (!project) {
    return <div className="empty-state">{t('common.loadFailed')}</div>;
  }

  const cover = project.cover?.url ?? project.thumbnail?.url ?? null;

  const narrative = [
    { title: t('projects.description'), body: project.description },
    { title: t('projects.challenge'), body: project.challenge },
    { title: t('projects.solution'), body: project.solution },
    { title: t('projects.approach'), body: project.approach },
  ].filter((block) => Boolean(block.body));

  return (
    <>
      <SEOHead seo={project.seo} title={`${project.title} — Ytech`} />

      <PageHeader
        title={project.title}
        description={project.short_description}
        crumbs={[{ label: t('nav.work'), path: '/work' }, { label: project.title }]}
        backgroundUrl={cover}
      />

      <section className="page-section section-space">
        <div className="container-site">
          {cover && (
            <div className="project-detail__hero">
              <img src={cover} alt={project.cover?.alt_text || project.title} />
            </div>
          )}

          <div className={`project-detail__layout${project.website_url ? '' : ' project-detail__layout--single'}`}>
            <div>
              {narrative.map((block) => (
                <div className="project-detail__block" key={block.title}>
                  <h2 className="project-detail__block-title">{block.title}</h2>
                  <div className="project-detail__prose">
                    <p>{block.body}</p>
                  </div>
                </div>
              ))}

              {project.key_features && project.key_features.length > 0 && (
                <div className="project-detail__block">
                  <h2 className="project-detail__block-title">{t('projects.keyFeatures')}</h2>
                  {project.key_features.map((group, index) => (
                    <div key={group.title ?? index}>
                      {group.title && (
                        <h3 style={{ marginTop: 24, fontSize: 20 }}>{group.title}</h3>
                      )}
                      <ul className="project-detail__list">
                        {group.points.map((point) => (
                          <li key={point}>
                            <Check size={17} />
                            {point}
                          </li>
                        ))}
                      </ul>
                    </div>
                  ))}
                </div>
              )}

              {project.results && project.results.length > 0 && (
                <div className="project-detail__block">
                  <h2 className="project-detail__block-title">{t('projects.results')}</h2>
                  <ul className="project-detail__list">
                    {project.results.map((item) => (
                      <li key={item}>
                        <Check size={17} />
                        {item}
                      </li>
                    ))}
                  </ul>
                </div>
              )}

              {project.gallery && project.gallery.length > 0 && (
                <div className="project-detail__block">
                  <h2 className="project-detail__block-title">{t('projects.gallery')}</h2>
                  <div className="project-detail__gallery">
                    {project.gallery.map((item) => (
                      <figure key={item.id}>
                        <img src={item.url} alt={item.caption ?? project.title} loading="lazy" />
                        {item.caption && <figcaption>{item.caption}</figcaption>}
                      </figure>
                    ))}
                  </div>
                </div>
              )}
            </div>

            {project.website_url && (
              <aside className="project-detail__aside">
                <Button
                  href={project.website_url}
                  external
                  icon={<ExternalLink size={15} />}
                >
                  {t('projects.visitSite')}
                </Button>
              </aside>
            )}
          </div>
        </div>
      </section>

      {project.related_projects && project.related_projects.length > 0 && (
        <section className="page-section section-space related-strip">
          <div className="container-site">
            <SectionTitle
              tagline={t('projects.indexLabel')}
              title={t('projects.relatedProjects')}
            />
            <div className="grid-3">
              {project.related_projects.map((item) => (
                <ProjectCard project={item} key={item.id} />
              ))}
            </div>
          </div>
        </section>
      )}
    </>
  );
}

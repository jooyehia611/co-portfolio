import { Link } from 'react-router-dom';
import { ArrowUpRight, Image as ImageIcon } from 'lucide-react';
import { useI18n } from '@/i18n';
import type { Project } from '@/types/project';

interface FeaturedProjectsSectionProps {
  title: string;
  projects: Project[];
}

function StrokeTitle({ title }: { title: string }) {
  return (
    <div className="stroke-text-title">
      <svg viewBox="0 0 1400 180" preserveAspectRatio="xMidYMid meet" aria-hidden={false}>
        <text x="50%" y="72%" textAnchor="middle">
          {title}
        </text>
      </svg>
    </div>
  );
}

function ProjectCard({ project }: { project: Project }) {
  const { t, localizedPath } = useI18n();
  const href = localizedPath(`/work/${project.slug}`);
  const image = project.thumbnail?.url ?? project.cover?.url ?? null;

  return (
    <article className="portfolio-one__card">
      <div className="portfolio-one__card__image">
        {image ? (
          <img
            src={image}
            alt={project.thumbnail?.alt_text || project.title}
            loading="lazy"
          />
        ) : (
          <div className="project-card__image--empty" style={{ width: '100%', height: '100%' }}>
            <ImageIcon size={40} aria-hidden />
          </div>
        )}
      </div>

      <div className="portfolio-one__card__content">
        {project.year && (
          <p className="portfolio-one__card__year">
            {t('home.designLabel')}: {project.year}
          </p>
        )}

        <Link to={href} className="circle-btn" aria-label={project.title}>
          <span>
            {t('home.view')}
            <br />
            {t('home.projects')}
          </span>
          <span className="circle-btn__icon" aria-hidden>
            <ArrowUpRight size={28} />
          </span>
          <span className="circle-btn__dot" aria-hidden />
        </Link>

        <div className="portfolio-one__card__text">
          <h2 className="portfolio-one__card__title">
            <Link to={href}>{project.title}</Link>
          </h2>
        </div>
      </div>
    </article>
  );
}

export function FeaturedProjectsSection({ title, projects }: FeaturedProjectsSectionProps) {
  const { t, localizedPath } = useI18n();

  if (projects.length === 0) return null;

  const half = Math.ceil(projects.length / 2);
  const rowOne = projects.slice(0, half);
  const rowTwo = projects.slice(half).length > 0 ? projects.slice(half) : rowOne;
  const trackOne = [...rowOne, ...rowOne];
  const trackTwo = [...rowTwo, ...rowTwo];

  return (
    <section className="portfolio-one stroke-section section-space-t">
      <div className="container-site">
        <StrokeTitle title={title} />
      </div>

      <div className="portfolio-one__rows">
        <div className="portfolio-one__track">
          {trackOne.map((project, i) => (
            <ProjectCard key={`r1-${project.id}-${i}`} project={project} />
          ))}
        </div>
        <div className="portfolio-one__track portfolio-one__track--reverse">
          {trackTwo.map((project, i) => (
            <ProjectCard key={`r2-${project.id}-${i}`} project={project} />
          ))}
        </div>
      </div>

      <div className="container-site">
        <div className="voice-testimonials__footer">
          <Link to={localizedPath('/work')} className="voice-testimonials__all">
            {t('projects.viewAll')} <ArrowUpRight size={19} aria-hidden="true" />
          </Link>
        </div>
      </div>
    </section>
  );
}

import { Link } from 'react-router-dom';
import { ArrowRight, Image as ImageIcon } from 'lucide-react';
import { useI18n } from '@/i18n';
import type { Project } from '@/types/project';

interface ProjectCardProps {
  project: Project;
}

export function ProjectCard({ project }: ProjectCardProps) {
  const { t, localizedPath } = useI18n();
  const href = localizedPath(`/work/${project.slug}`);
  const image = project.cover?.url ?? project.thumbnail?.url ?? null;

  const meta = project.year ? [String(project.year)] : [];

  return (
    <article className="project-card">
      <div
        className={image ? 'project-card__image' : 'project-card__image project-card__image--empty'}
      >
        {image ? (
          <Link to={href}>
            <img src={image} alt={project.cover?.alt_text || project.title} loading="lazy" />
          </Link>
        ) : (
          <ImageIcon size={38} aria-hidden />
        )}
      </div>

      <div className="project-card__body">
        {meta.length > 0 && (
          <div className="project-card__meta">
            {meta.map((item) => (
              <span key={item}>{item}</span>
            ))}
          </div>
        )}

        <h3 className="project-card__title">
          <Link to={href}>{project.title}</Link>
        </h3>

        {project.short_description && (
          <p className="project-card__text">{project.short_description}</p>
        )}

        {project.technologies && project.technologies.length > 0 && (
          <ul className="project-card__tags">
            {project.technologies.slice(0, 4).map((tech) => (
              <li key={tech.id}>{tech.name}</li>
            ))}
          </ul>
        )}

        <div className="blog-card__more">
          <Link to={href} className="yt-link">
            {t('common.explore')}
            <span className="yt-link__icon" aria-hidden>
              <ArrowRight size={15} />
            </span>
          </Link>
        </div>
      </div>
    </article>
  );
}

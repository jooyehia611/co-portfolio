import { Link } from 'react-router-dom';
import { useI18n } from '@/i18n';
import { SplitReveal } from '@/components/ui/SplitReveal';

interface Crumb {
  label: string;
  path?: string;
}

interface PageHeaderProps {
  title: string;
  description?: string | null;
  crumbs?: Crumb[];
  backgroundUrl?: string | null;
}

export function PageHeader({ title, description, crumbs = [], backgroundUrl }: PageHeaderProps) {
  const { t, localizedPath } = useI18n();

  const trail: Crumb[] = [{ label: t('common.home'), path: '/' }, ...crumbs];

  return (
    <section className="page-header">
      {backgroundUrl && (
        <div
          className="page-header__bg"
          style={{ backgroundImage: `url(${backgroundUrl})` }}
          aria-hidden
        />
      )}
      <div className="yt-stripes" aria-hidden />

      <div className="container-site page-header__inner">
        <SplitReveal as="h1" className="page-header__title">
          {title}
        </SplitReveal>

        {description && <p className="page-header__text">{description}</p>}

        <nav aria-label="Breadcrumb">
          <ol className="page-header__breadcrumb">
            {trail.map((crumb, i) => {
              const isLast = i === trail.length - 1;
              return (
                <li key={`${crumb.label}-${i}`} aria-current={isLast ? 'page' : undefined}>
                  {crumb.path && !isLast ? (
                    <Link to={localizedPath(crumb.path)}>{crumb.label}</Link>
                  ) : (
                    crumb.label
                  )}
                </li>
              );
            })}
          </ol>
        </nav>
      </div>
    </section>
  );
}

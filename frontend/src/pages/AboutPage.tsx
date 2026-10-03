import { Compass, Eye, Target } from 'lucide-react';
import { fetchAbout } from '@/services/contactService';
import { useLocaleData } from '@/hooks/useLocaleData';
import { useI18n } from '@/i18n';
import { SEOHead } from '@/components/ui/SEOHead';
import { LoadingSpinner } from '@/components/ui/LoadingSpinner';
import { PageHeader } from '@/components/ui/PageHeader';
import { SectionTitle } from '@/components/ui/SectionTitle';
import { StatisticsSection } from '@/features/home/StatisticsSection';
import { BusinessValueSection } from '@/features/home/BusinessValueSection';
import { ProcessSection } from '@/features/home/ProcessSection';
import { TeamSection } from '@/features/home/TeamSection';
import { TechnologySection } from '@/features/home/TechnologySection';

const blockIcons = [Compass, Target, Eye];

export function AboutPage() {
  const { t } = useI18n();
  const { data, loading } = useLocaleData(fetchAbout);

  if (loading) return <LoadingSpinner />;
  if (!data) {
    return <div className="empty-state">{t('common.loadFailed')}</div>;
  }

  const blocks = [
    { title: data.story.title, content: data.story.content },
    { title: data.mission.title, content: data.mission.content },
    { title: data.vision.title, content: data.vision.content },
  ].filter((b) => b.content);

  return (
    <>
      <SEOHead seo={data.seo} title={data.seo?.page_title || `${t('nav.about')} — Ytech`} />

      <PageHeader
        title={data.seo?.page_title || data.hero.title}
        description={data.seo?.page_description || data.hero.description}
        crumbs={[{ label: t('nav.about') }]}
      />

      <section className="page-section section-space">
        <div className="container-site">
          <SectionTitle
            tagline={t('about.story')}
            title={data.story.title}
            align="center"
          />

          <div className="about-story">
            {blocks.map((block, index) => {
              const Icon = blockIcons[index % blockIcons.length];
              return (
                <article className="about-story__card" key={block.title}>
                  <span className="about-story__icon" aria-hidden>
                    <Icon size={22} />
                  </span>
                  <h3 className="about-story__title">{block.title}</h3>
                  <p className="about-story__text">{block.content}</p>
                </article>
              );
            })}
          </div>
        </div>
      </section>

      <StatisticsSection statistics={data.statistics} />

      <BusinessValueSection
        tagline={data.values_section?.subtitle || t('about.valuesEyebrow')}
        title={data.values_section?.title || t('about.values')}
        values={data.values}
      />

      <TeamSection
        tagline={data.team_section?.subtitle || t('about.teamEyebrow')}
        title={data.team_section?.title || t('about.team')}
        text={data.team_section?.description}
        members={data.team}
      />

      <ProcessSection
        tagline={data.process_section?.subtitle || t('about.processEyebrow')}
        title={data.process_section?.title || t('about.process')}
        text={data.process_section?.description}
        steps={data.process_steps}
        ctaLabel={data.process_section?.button_label}
        ctaHref={data.process_section?.button_href}
      />

      <TechnologySection technologies={data.technologies} />
    </>
  );
}

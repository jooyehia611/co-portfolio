import { fetchHomeData } from '@/services/homeService';
import { useSettings } from '@/hooks/useSettings';
import { useLocaleData } from '@/hooks/useLocaleData';
import { useI18n } from '@/i18n';
import { SEOHead } from '@/components/ui/SEOHead';
import { LoadingSpinner } from '@/components/ui/LoadingSpinner';
import { Marquee } from '@/components/ui/Marquee';
import { HeroSection } from '@/features/home/HeroSection';
import { StatisticsSection } from '@/features/home/StatisticsSection';
import { AboutSection } from '@/features/home/AboutSection';
import { WordmarkSection } from '@/features/home/WordmarkSection';
import { ServicesSection } from '@/features/home/ServicesSection';
import { FeaturedProjectsSection } from '@/features/home/FeaturedProjectsSection';
import { TeamSection } from '@/features/home/TeamSection';
import { ProcessSection } from '@/features/home/ProcessSection';
import { FocusBandSection } from '@/features/home/FocusBandSection';
import { BusinessValueSection } from '@/features/home/BusinessValueSection';
import { VoiceTestimonialsSection } from '@/features/home/VoiceTestimonialsSection';
import { FinalCTASection } from '@/features/home/FinalCTASection';

/* Fallback media shipped with the frontend, used when the CMS has none. */
const SHOWREEL_POSTER = '/media/hero/ytech-showreel-poster.jpg';
const HOME_BACKDROP = '/theme/backgrounds/home-bg2.png';

export function HomePage() {
  const { t } = useI18n();
  const { settings } = useSettings();
  const { data, loading } = useLocaleData(fetchHomeData);

  if (loading) return <LoadingSpinner />;
  if (!data) {
    return <div className="empty-state">{t('common.loadFailed')}</div>;
  }

  const { sections } = data;

  const aboutImageOne = sections.about.image?.url ?? SHOWREEL_POSTER;
  const aboutImageTwo = sections.about.image_two?.url ?? HOME_BACKDROP;

  const marqueeItems =
    sections.marquee.items.length > 0
      ? sections.marquee.items
      : data.services.map((s) => s.title);

  return (
    <>
      <SEOHead
        seo={data.seo}
        title={settings?.site_title || undefined}
        companyName={settings?.company_name}
        siteTitle={settings?.site_title}
      />

      <HeroSection data={data.hero} services={data.services} />

      <StatisticsSection statistics={data.statistics} />

      <AboutSection
        tagline={sections.about.subtitle}
        title={sections.about.title}
        text={sections.about.description}
        imageOne={aboutImageOne}
        imageTwo={aboutImageTwo}
        yearsCount={sections.about.years_count}
        progressValue={sections.about.progress_value}
        progressText={sections.about.progress_text}
        ctaLabel={sections.about.button_label}
        ctaHref={sections.about.button_href}
        sinceYear={sections.about.since_year}
        sinceLabel={sections.about.since_label}
        awardWinning={sections.about.award_winning}
        experienceLabel={sections.about.experience_label}
        challengeLabel={sections.about.challenge_label}
      />

      <WordmarkSection
        word="Technology"
        imageUrl={sections.wordmark.image?.url ?? null}
      />

      <ServicesSection
        tagline={sections.services.subtitle}
        title={sections.services.title}
        text={sections.services.description}
        services={data.services}
      />

      <Marquee items={marqueeItems} />

      <FeaturedProjectsSection title={sections.projects.title} projects={data.projects} />

      <TeamSection
        tagline={sections.team.subtitle}
        title={sections.team.title}
        text={sections.team.description}
        members={data.team_members}
      />

      <ProcessSection
        tagline={sections.process.subtitle}
        title={sections.process.title}
        text={sections.process.description}
        steps={data.process_steps}
        ctaLabel={sections.process.button_label}
        ctaHref={sections.process.button_href}
      />

      <FocusBandSection
        tagline={sections.clients.subtitle}
        title={sections.clients.title}
        text={sections.clients.description}
        items={sections.clients.items}
        imageUrl={sections.clients.image?.url ?? null}
      />

      <BusinessValueSection
        tagline={sections.business_values.subtitle}
        title={sections.business_values.title}
        text={sections.business_values.description}
        values={data.business_values}
      />

      <VoiceTestimonialsSection
        tagline={sections.testimonials.subtitle}
        title={sections.testimonials.title}
        text={sections.testimonials.description}
        testimonials={data.testimonials}
      />

      <FinalCTASection
        eyebrow={sections.cta.eyebrow}
        title={sections.cta.title}
        description={sections.cta.description}
        buttonLabel={sections.cta.button_label}
        buttonHref={sections.cta.button_href}
      />
    </>
  );
}

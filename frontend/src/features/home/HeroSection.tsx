import { ArrowRight, BarChart3, Lightbulb, Play } from 'lucide-react';
import { Link } from 'react-router-dom';
import { useI18n } from '@/i18n';
import type { HeroData } from '@/types/home';
import type { Service } from '@/types/service';
import { serviceIcon } from '@/utils/serviceIcons';
import { HeroBackground } from './hero/HeroBackground';
import { LaptopMockup } from './hero/LaptopMockup';
import { MobileMockup } from './hero/MobileMockup';
import { FloatingCard } from './hero/FloatingCard';
import { ServiceCard } from './hero/ServiceCard';

interface HeroSectionProps {
  data: HeroData;
  services?: Service[];
}

const FALLBACK_KEYS = [
  'hero.badgeWeb',
  'hero.badgeMobile',
  'hero.badgeBusiness',
  'hero.badgeCloud',
] as const;

function pickHeroServices(services: Service[]): Service[] {
  const featured = services.filter((s) => s.is_featured);
  if (featured.length > 0) return featured.slice(0, 4);
  return services.slice(0, 4);
}

function pick(value: string | undefined | null, fallback: string): string {
  const trimmed = value?.trim();
  return trimmed ? trimmed : fallback;
}

export function HeroSection({ data, services = [] }: HeroSectionProps) {
  const { t, localizedPath, dir } = useI18n();

  const kicker = pick(data.kicker, t('hero.kicker'));
  const line1Prefix = pick(data.headline?.line1_prefix, t('hero.line1Before'));
  const line1Accent = pick(data.headline?.line1_accent, t('hero.line1Accent'));
  const line2 = pick(data.headline?.line2, t('hero.line2'));
  const lead = pick(data.description, t('hero.lead'));
  const primaryLabel = pick(data.primary_cta?.label, t('hero.ctaPrimary'));
  const primaryHref = pick(data.primary_cta?.href, '/contact');
  const secondaryLabel = pick(data.secondary_cta?.label, t('hero.ctaSecondary'));
  const secondaryHref = pick(data.secondary_cta?.href, '/work');
  const growTitle = pick(data.float_grow?.title, t('hero.floatGrowTitle'));
  const growSub = pick(data.float_grow?.subtitle, t('hero.floatGrowSub'));
  const ideaTitle = pick(data.float_idea?.title, t('hero.floatIdeaTitle'));
  const ideaSub = pick(data.float_idea?.subtitle, t('hero.floatIdeaSub'));
  const scriptLine1 = pick(data.script?.line1, 'Ideas');
  const scriptLine2 = pick(data.script?.line2, 'To Impact');

  const picked = pickHeroServices(services);
  const serviceCards =
    picked.length > 0
      ? picked.map((service, index) => ({
          key: String(service.id),
          label: service.title,
          href: localizedPath(`/services/${service.slug}`),
          icon: serviceIcon(service.icon, index),
        }))
      : FALLBACK_KEYS.map((key, index) => ({
          key,
          label: t(key),
          href: localizedPath('/services'),
          icon: serviceIcon(null, index),
        }));

  return (
    <section className="hero-pro">
      <HeroBackground />

      <div className="container-site">
        <div className="hero-pro__layout">
          <div className="hero-pro__copy" dir={dir}>
            <p className="hero-pro__kicker">{kicker}</p>

            <h1 className="hero-pro__title">
              <span className="hero-pro__title-line">
                {line1Prefix} <em>{line1Accent}</em>
              </span>
              <span className="hero-pro__title-line">{line2}</span>
            </h1>

            <p className="hero-pro__lead">{lead}</p>

            <div className="hero-pro__cta">
              <Link to={localizedPath(primaryHref)} className="hero-pro__btn">
                {primaryLabel}
                <ArrowRight size={16} strokeWidth={2.4} />
              </Link>
              <Link to={localizedPath(secondaryHref)} className="hero-pro__btn hero-pro__btn--ghost">
                <Play size={14} fill="currentColor" />
                {secondaryLabel}
              </Link>
            </div>

            <ul className="hero-pro__services" dir={dir}>
              {serviceCards.map((item, index) => (
                <ServiceCard
                  key={item.key}
                  icon={item.icon}
                  label={item.label}
                  href={item.href}
                  delay={`${0.45 + index * 0.08}s`}
                />
              ))}
            </ul>
          </div>

          <div className="hero-pro__stage">
            <svg className="hero-pro__links" viewBox="0 0 760 560" fill="none" aria-hidden>
              <path d="M168 86 C 240 78, 310 150, 372 214" />
              <path d="M628 78 C 540 70, 470 150, 410 210" />
              <circle cx="168" cy="86" r="4" />
              <circle cx="628" cy="78" r="4" />
            </svg>

            <div className="hero-cluster">
              <div className="hero-rock" aria-hidden>
                <img
                  className="hero-rock__shot"
                  src="/media/hero/hero-rock.png?v=5"
                  alt=""
                  width={1280}
                  height={720}
                />
              </div>
              <LaptopMockup />
              <MobileMockup />
              <p className="hero-pro__script" aria-hidden>
                {scriptLine1}
                <span>{scriptLine2}</span>
              </p>
            </div>

            <FloatingCard
              variant="grow"
              title={growTitle}
              subtitle={growSub}
              icon={<BarChart3 size={18} />}
            />
            <FloatingCard
              variant="idea"
              title={ideaTitle}
              subtitle={ideaSub}
              icon={<Lightbulb size={18} />}
            />
          </div>
        </div>
      </div>
    </section>
  );
}

import { useEffect, useId, useRef } from 'react';
import { ArrowUpRight } from 'lucide-react';
import { useI18n } from '@/i18n';
import { Button } from '@/components/ui/Button';
import { SectionTitle } from '@/components/ui/SectionTitle';
import { RevealText } from '@/components/ui/RevealText';
import { CountUp } from '@/components/ui/CountUp';
import { gsap, prefersReducedMotion } from '@/lib/gsap';

interface AboutSectionProps {
  tagline?: string | null;
  title: string;
  text?: string | null;
  imageOne?: string | null;
  imageTwo?: string | null;
  yearsCount?: string | null;
  progressValue?: number | null;
  progressText?: string | null;
  ctaLabel?: string | null;
  ctaHref?: string | null;
  sinceYear?: string | null;
  sinceLabel?: string | null;
  awardWinning?: string | null;
  experienceLabel?: string | null;
  challengeLabel?: string | null;
}

function CurvedBadge({ text }: { text: string }) {
  const pathId = useId().replace(/:/g, '');

  return (
    <div className="about-badge">
      <span className="about-badge__icon" aria-hidden>
        <ArrowUpRight size={26} />
      </span>
      <svg className="about-badge__ring" viewBox="0 0 130 130" aria-hidden>
        <defs>
          <path
            id={pathId}
            d="M65 65 m-50 0 a50 50 0 1 1 100 0 a50 50 0 1 1 -100 0"
          />
        </defs>
        <text>
          <textPath href={`#${pathId}`}>{text}</textPath>
        </text>
      </svg>
    </div>
  );
}

/*
  Editorial about band: one dominant photo + years overlay on the left,
  title / body / unboxed proof / CTA on the right.
*/
export function AboutSection({
  tagline,
  title,
  text,
  imageOne,
  imageTwo,
  yearsCount,
  progressValue,
  progressText,
  ctaLabel,
  ctaHref,
  sinceYear,
  sinceLabel,
  awardWinning,
}: AboutSectionProps) {
  const { t, localizedPath } = useI18n();
  const mediaRef = useRef<HTMLDivElement>(null);

  const yearsNum = parseInt(String(yearsCount ?? '').replace(/[^\d]/g, ''), 10);
  const resolvedSince =
    (sinceYear && String(sinceYear).trim()) ||
    (Number.isFinite(yearsNum) && yearsNum > 0
      ? String(new Date().getFullYear() - yearsNum)
      : '2018');
  const badgeText = `- ${sinceLabel || t('home.since')} - ${resolvedSince} - ${awardWinning || t('home.awardWinning')} -`;

  const primaryImage = imageOne || imageTwo || null;
  const showYears = Number.isFinite(yearsNum) && yearsNum > 0;

  useEffect(() => {
    const media = mediaRef.current;
    if (!media || prefersReducedMotion()) return;

    gsap.set(media, { autoAlpha: 0, y: 40 });

    const io = new IntersectionObserver(
      ([entry]) => {
        if (!entry.isIntersecting) return;
        gsap.to(media, {
          autoAlpha: 1,
          y: 0,
          duration: 1,
          ease: 'power3.out',
          overwrite: true,
        });
        io.disconnect();
      },
      { threshold: 0.2 },
    );

    io.observe(media);
    return () => io.disconnect();
  }, [primaryImage]);

  return (
    <section className="about-one section-space" id="about">
      <div className="container-site">
        <div className="about-one__grid">
          <div className="about-one__media" ref={mediaRef}>
            <div className="about-one__figure">
              {primaryImage ? (
                <img src={primaryImage} alt={title} loading="lazy" />
              ) : (
                <div className="about-one__figure-empty" aria-hidden />
              )}

              <CurvedBadge text={badgeText} />

              {showYears && (
                <div className="about-one__years">
                  <span className="about-one__years-value">
                    <CountUp value={yearsNum} suffix="+" />
                  </span>
                  <span className="about-one__years-label">
                    {t('home.experience')}
                  </span>
                </div>
              )}
            </div>
          </div>

          <div className="about-one__content">
            <SectionTitle tagline={tagline} title={title} />

            {text && <RevealText className="about-one__body">{text}</RevealText>}

            {typeof progressValue === 'number' && progressValue > 0 && (
              <div className="about-one__stat">
                <h3 className="about-one__stat-value">
                  <CountUp value={progressValue} suffix="%" />
                </h3>
                {progressText && (
                  <p className="about-one__stat-text">{progressText}</p>
                )}
              </div>
            )}

            {ctaHref && (
              <div className="about-one__cta">
                <Button href={localizedPath(ctaHref)}>
                  {ctaLabel || t('home.aboutMore')}
                </Button>
              </div>
            )}
          </div>
        </div>
      </div>
    </section>
  );
}

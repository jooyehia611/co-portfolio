import { useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { useI18n } from '@/i18n';
import { Button } from '@/components/ui/Button';
import { SectionTitle } from '@/components/ui/SectionTitle';
import { RevealText } from '@/components/ui/RevealText';
import { gsap, ScrollTrigger, prefersReducedMotion } from '@/lib/gsap';
import type { ProcessStep } from '@/types/shared';

interface ProcessSectionProps {
  tagline?: string | null;
  title: string;
  text?: string | null;
  steps: ProcessStep[];
  images?: Array<string | null | undefined>;
  ctaLabel?: string | null;
  ctaHref?: string | null;
}

/* Down-chevron used on Amoxi's dashed step rails. */
function ArrowDownIcon() {
  return (
    <svg viewBox="0 0 14 14" width="14" height="14" fill="none" aria-hidden>
      <path
        d="M7 1.5v9.2M3.2 7.5 7 11.3l3.8-3.8"
        stroke="currentColor"
        strokeWidth="1.4"
        strokeLinecap="round"
        strokeLinejoin="round"
      />
    </svg>
  );
}

/*
  Four-column process band modeled on Amoxi's work-process:
  staggered dashed rails + arrow heads, capsule photos with scroll zoom,
  and the hook arrows that lead into the CTA.
*/
export function ProcessSection({
  tagline,
  title,
  text,
  steps,
  images = [],
  ctaLabel,
  ctaHref,
}: ProcessSectionProps) {
  const { t, localizedPath, dir } = useI18n();
  const rootRef = useRef<HTMLElement>(null);

  useEffect(() => {
    const root = rootRef.current;
    if (!root || prefersReducedMotion()) return;

    const observers: IntersectionObserver[] = [];
    const cols = Array.from(root.querySelectorAll<HTMLElement>('.work-process__col'));
    const button = root.querySelector<HTMLElement>('.work-process__button');
    const zooms = Array.from(root.querySelectorAll<HTMLElement>('.work-process__image.zoom-effect'));

    const reveal = (el: HTMLElement, delay = 0) => {
      gsap.fromTo(
        el,
        { autoAlpha: 0, y: 60 },
        { autoAlpha: 1, y: 0, duration: 1.1, delay, ease: 'power3.out', overwrite: true },
      );
    };

    cols.forEach((col, index) => {
      gsap.set(col, { autoAlpha: 0, y: 60 });
      const io = new IntersectionObserver(
        ([entry]) => {
          if (!entry.isIntersecting) return;
          reveal(col, 0.1 * (index + 1));
          io.disconnect();
        },
        { threshold: 0.12, rootMargin: '0px 0px -8% 0px' },
      );
      io.observe(col);
      observers.push(io);
    });

    if (button) {
      gsap.set(button, { autoAlpha: 0, y: 40 });
      const io = new IntersectionObserver(
        ([entry]) => {
          if (!entry.isIntersecting) return;
          gsap.to(button, { autoAlpha: 1, y: 0, duration: 1.1, ease: 'power3.out', overwrite: true });
          io.disconnect();
        },
        { threshold: 0.1 },
      );
      io.observe(button);
      observers.push(io);
    }

    const ctx = gsap.context(() => {
      zooms.forEach((el) => {
        gsap
          .timeline({
            scrollTrigger: {
              trigger: el,
              scrub: 1,
              start: 'top 80%',
              end: 'bottom 60%',
            },
          })
          .set(el, { transformOrigin: 'center center' })
          .fromTo(
            el,
            { scale: 0.7 },
            { scale: 1, duration: 1, immediateRender: false },
          );
      });
    }, root);

    const refresh = requestAnimationFrame(() => ScrollTrigger.refresh());

    return () => {
      cancelAnimationFrame(refresh);
      observers.forEach((io) => io.disconnect());
      ctx.revert();
    };
  }, [steps]);

  if (steps.length === 0) return null;

  return (
    <section ref={rootRef} className="work-process section-space">
      <div className="container-site">
        <div className="work-process__top">
          <SectionTitle tagline={tagline || t('home.processTagline')} title={title} />
          {(text || t('home.processText')) ? (
            <RevealText className="work-process__text">{text || t('home.processText')}</RevealText>
          ) : null}
        </div>

        <div className="work-process__grid">
          {steps.map((step, index) => {
            const image =
              step.image?.url ?? images[index] ?? `/media/work-process/step-${(index % 4) + 1}.jpg`;
            const href = localizedPath('/about');
            const showShape = index < 3;

            return (
              <div
                className={`work-process__col work-process__col--${(index % 4) + 1}`}
                key={step.id}
              >
                <div className={`work-process__item work-process__item--${(index % 4) + 1}`}>
                  <div className="work-process__step">
                    <span className="work-process__step__text">{t('home.step')}</span>
                  </div>

                  <div className="work-process__border" aria-hidden>
                    <span className="work-process__border__icon">
                      <ArrowDownIcon />
                    </span>
                  </div>

                  <h3 className="work-process__title">
                    <Link to={href}>{step.title}</Link>
                  </h3>

                  <div className="work-process__image zoom-effect">
                    <img src={image} alt="" loading="lazy" />
                  </div>

                  {showShape ? (
                    <div className="work-process__shape" aria-hidden>
                      <img
                        src={
                          dir === 'rtl'
                            ? '/media/shapes/work-process-shape-rtl.png'
                            : '/media/shapes/work-process-shape.png'
                        }
                        alt=""
                        width={120}
                        height={116}
                      />
                    </div>
                  ) : null}
                </div>
              </div>
            );
          })}
        </div>

        <div className="work-process__button">
          <Button href={localizedPath(ctaHref || '/work')}>
            {ctaLabel || t('common.viewAll')}
          </Button>
        </div>
      </div>
    </section>
  );
}

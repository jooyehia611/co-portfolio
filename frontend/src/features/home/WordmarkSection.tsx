import { useEffect, useRef } from 'react';
import { gsap, ScrollTrigger, prefersReducedMotion } from '@/lib/gsap';

interface WordmarkSectionProps {
  word?: string;
  imageUrl?: string | null;
}

/*
  Brand interlude band modeled on Amoxi's amoxi-area:
  outlined word + favicon mark, corner brackets, dotted rails,
  plus the same scroll animations (zoom, bg parallax, border wipe).
*/
export function WordmarkSection({ word, imageUrl }: WordmarkSectionProps) {
  const rootRef = useRef<HTMLElement>(null);
  const label = (word?.trim() || 'Technology').toUpperCase();
  const bg = imageUrl || '/media/hero/wordmark-bg.jpg';

  useEffect(() => {
    const root = rootRef.current;
    if (!root || prefersReducedMotion()) return;

    const ctx = gsap.context(() => {
      const bgEl = root.querySelector<HTMLElement>('.wordmark-area__bg');
      const mark = root.querySelector<HTMLElement>('.wordmark-area__mark');
      const leftBorders = root.querySelectorAll('.wordmark-area__border--ltr');
      const rightBorders = root.querySelectorAll('.wordmark-area__border--rtl');
      const isRTL = getComputedStyle(document.documentElement).direction === 'rtl';

      // Background parallax — Amoxi `.img-move-lr`
      if (bgEl) {
        gsap.set(bgEl, {
          width: '125%',
          maxWidth: 'none',
          xPercent: isRTL ? 12.5 : -12.5,
          willChange: 'transform',
        });

        gsap.to(bgEl, {
          xPercent: 0,
          ease: 'none',
          scrollTrigger: {
            trigger: root,
            start: 'top bottom',
            end: 'bottom top',
            scrub: 1,
          },
        });
      }

      // Title/mark zoom — Amoxi `.zoom-effect`
      if (mark) {
        gsap
          .timeline({
            scrollTrigger: {
              trigger: mark,
              scrub: 1,
              start: 'top 80%',
              end: 'bottom 60%',
              toggleActions: 'play none none reverse',
            },
          })
          .set(mark, { transformOrigin: 'center center' })
          .fromTo(
            mark,
            { scale: 0.7 },
            { scale: 1, duration: 1, immediateRender: false },
          );
      }

      // Corner brackets — Amoxi `.left-to-right-anim` / `.right-to-left-anim`
      if (leftBorders.length) {
        gsap
          .timeline({
            scrollTrigger: {
              trigger: root,
              start: 'top 80%',
              end: 'bottom 10%',
              scrub: 2,
            },
          })
          .fromTo(leftBorders, { x: -200 }, { x: 0, duration: 1.6 });
      }

      if (rightBorders.length) {
        gsap
          .timeline({
            scrollTrigger: {
              trigger: root,
              start: 'top 80%',
              end: 'bottom 10%',
              scrub: 2,
            },
          })
          .fromTo(rightBorders, { x: 200 }, { x: 0, duration: 1.6 });
      }
    }, root);

    const refresh = requestAnimationFrame(() => ScrollTrigger.refresh());

    return () => {
      cancelAnimationFrame(refresh);
      ctx.revert();
    };
  }, []);

  return (
    <section ref={rootRef} className="wordmark-area" aria-hidden>
      <div className="wordmark-area__bg" style={{ backgroundImage: `url(${bg})` }} />

      <div className="wordmark-area__rail wordmark-area__rail--top" />
      <div className="wordmark-area__rail wordmark-area__rail--bottom" />

      <div className="container-site">
        <div className="wordmark-area__content">
          <div className="wordmark-area__mark">
            <img
              className="wordmark-area__icon"
              src="/logo-icon.png?v=3"
              alt=""
              width={256}
              height={256}
            />
            <h2 className="wordmark-area__title">{label}</h2>
          </div>

          <span className="wordmark-area__border wordmark-area__border--1 wordmark-area__border--ltr" />
          <span className="wordmark-area__border wordmark-area__border--2 wordmark-area__border--rtl" />
          <span className="wordmark-area__border wordmark-area__border--3 wordmark-area__border--ltr" />
          <span className="wordmark-area__border wordmark-area__border--4 wordmark-area__border--rtl" />

          <span className="wordmark-area__dot wordmark-area__dot--1" />
          <span className="wordmark-area__dot wordmark-area__dot--2" />
          <span className="wordmark-area__dot wordmark-area__dot--3" />
        </div>
      </div>
    </section>
  );
}

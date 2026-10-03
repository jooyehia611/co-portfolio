import { useEffect } from 'react';
import { useLocation } from 'react-router-dom';
import { ScrollSmoother, ScrollTrigger, prefersReducedMotion } from '@/lib/gsap';

/*
  Inertial page scrolling, matching the reference design's feel.
  Skipped on touch devices and when the visitor asks for reduced motion,
  where native scrolling is both faster and more predictable.
*/
export function useSmoothScroll() {
  const location = useLocation();

  useEffect(() => {
    if (prefersReducedMotion()) return;
    if (window.matchMedia('(pointer: coarse)').matches) return;
    if (!document.getElementById('smooth-wrapper')) return;

    const smoother = ScrollSmoother.create({
      wrapper: '#smooth-wrapper',
      content: '#smooth-content',
      smooth: 1.2,
      effects: true,
      normalizeScroll: true,
    });

    return () => {
      smoother.kill();
    };
  }, []);

  /* New route means new content height, so triggers need remeasuring. */
  useEffect(() => {
    const smoother = ScrollSmoother.get();
    if (smoother) smoother.scrollTo(0, false);
    else window.scrollTo(0, 0);

    const raf = requestAnimationFrame(() => ScrollTrigger.refresh());
    return () => cancelAnimationFrame(raf);
  }, [location.pathname]);
}

import { useEffect, useRef, type ElementType, type ReactNode } from 'react';
import { gsap, isOnScreen, prefersReducedMotion } from '@/lib/gsap';
import { cn } from '@/utils/cn';

interface TitleRiseProps {
  children: ReactNode;
  as?: ElementType;
  className?: string;
  lineSelector?: string;
}

/*
  The reference hero title: each line rises out of a 3D flip
  (rotationX -80 → 0) instead of a gradient wipe.
*/
export function TitleRise({
  children,
  as: Tag = 'h1',
  className,
  lineSelector = '.hero-one__title__line',
}: TitleRiseProps) {
  const ref = useRef<HTMLElement>(null);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;

    if (prefersReducedMotion()) return;

    const lines = el.querySelectorAll(lineSelector);
    if (lines.length === 0) return;

    const ctx = gsap.context(() => {
      gsap.set(el, { perspective: 400 });

      gsap.from(lines, {
        duration: 1,
        delay: 0.3,
        opacity: 0,
        rotationX: -80,
        force3D: true,
        transformOrigin: 'top center -50',
        stagger: 0.1,
        ease: 'power3.out',
        ...(isOnScreen(el)
          ? {}
          : { scrollTrigger: { trigger: el, start: 'top 90%', once: true } }),
      });
    }, el);

    return () => ctx.revert();
  }, [children, lineSelector]);

  return (
    <Tag ref={ref} className={cn(className)}>
      {children}
    </Tag>
  );
}

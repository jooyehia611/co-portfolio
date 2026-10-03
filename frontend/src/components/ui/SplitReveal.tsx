import { useEffect, useRef, type ElementType, type ReactNode } from 'react';
import { gsap, SplitText, ytEase, isOnScreen, prefersReducedMotion } from '@/lib/gsap';
import { cn } from '@/utils/cn';

interface SplitRevealProps {
  children: ReactNode;
  as?: ElementType;
  className?: string;
  /* Tints the wipe with the accent instead of white. */
  accent?: boolean;
  stagger?: number;
  duration?: number;
}

/*
  Heading treatment from the reference design: text sits on a 200%-wide
  two-stop gradient and the fill sweeps in line by line as it scrolls up.
*/
export function SplitReveal({
  children,
  as: Tag = 'h2',
  className,
  accent = false,
  stagger = 0.18,
  duration = 1.1,
}: SplitRevealProps) {
  const ref = useRef<HTMLElement>(null);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;

    if (prefersReducedMotion()) {
      el.style.color = accent ? 'var(--yt-base)' : 'var(--yt-white)';
      el.style.backgroundImage = 'none';
      return;
    }

    const gradient = accent
      ? 'linear-gradient(to right, rgba(var(--yt-base-rgb), 0.35) 50%, var(--yt-base) 50%)'
      : 'linear-gradient(to right, rgba(var(--yt-white-rgb), 0.2) 50%, var(--yt-white) 50%)';

    const ctx = gsap.context(() => {
      /* autoSplit re-measures the line breaks once webfonts land and on resize. */
      SplitText.create(el, {
        type: 'lines',
        linesClass: 'bw-split-line',
        autoSplit: true,
        onSplit: (self) => {
          gsap.set(self.lines, {
            display: 'block',
            backgroundImage: gradient,
            backgroundSize: '200% 100%',
            backgroundPositionX: '0%',
            backgroundClip: 'text',
            webkitBackgroundClip: 'text',
            color: 'transparent',
          });

          return gsap.to(self.lines, {
            backgroundPositionX: '-100%',
            ease: ytEase,
            duration,
            stagger,
            ...(isOnScreen(el)
              ? {}
              : { scrollTrigger: { trigger: el, start: 'top 85%', once: true } }),
          });
        },
      });
    }, el);

    return () => ctx.revert();
  }, [children, accent, stagger, duration]);

  return (
    <Tag ref={ref} className={cn(className)}>
      {children}
    </Tag>
  );
}

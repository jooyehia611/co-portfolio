import { useEffect, useRef, type ElementType, type ReactNode } from 'react';
import { gsap, SplitText, ytEase, isOnScreen, prefersReducedMotion } from '@/lib/gsap';
import { cn } from '@/utils/cn';

interface RevealTextProps {
  children: ReactNode;
  as?: ElementType;
  className?: string;
  delay?: number;
}

/* Lines rise out of an overflow mask, one after the other. */
export function RevealText({ children, as: Tag = 'p', className, delay = 0 }: RevealTextProps) {
  const ref = useRef<HTMLElement>(null);

  useEffect(() => {
    const el = ref.current;
    if (!el || prefersReducedMotion()) return;

    const ctx = gsap.context(() => {
      SplitText.create(el, {
        type: 'lines',
        linesClass: 'bw-line',
        mask: 'lines',
        autoSplit: true,
        onSplit: (self) =>
          gsap.from(self.lines, {
            yPercent: 110,
            opacity: 0,
            duration: 0.9,
            delay,
            stagger: 0.12,
            ease: ytEase,
            ...(isOnScreen(el)
              ? {}
              : { scrollTrigger: { trigger: el, start: 'top 88%', once: true } }),
          }),
      });
    }, el);

    return () => ctx.revert();
  }, [children, delay]);

  return (
    <Tag ref={ref} className={cn('bw-reveal-text', className)}>
      {children}
    </Tag>
  );
}

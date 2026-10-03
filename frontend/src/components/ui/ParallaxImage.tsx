import { useEffect, useRef } from 'react';
import { gsap, ScrollTrigger, prefersReducedMotion } from '@/lib/gsap';
import { cn } from '@/utils/cn';

interface ParallaxImageProps {
  src: string;
  alt: string;
  className?: string;
  imgClassName?: string;
  /* Horizontal travel direction as the frame scrolls past. */
  direction?: 'lr' | 'rl' | 'zoom';
  amount?: number;
  children?: React.ReactNode;
}

/*
  The reference design overfills each image frame and drifts the image
  sideways (or scales it) while the frame moves through the viewport.
*/
export function ParallaxImage({
  src,
  alt,
  className,
  imgClassName,
  direction = 'lr',
  amount = 60,
  children,
}: ParallaxImageProps) {
  const wrapRef = useRef<HTMLDivElement>(null);
  const imgRef = useRef<HTMLImageElement>(null);

  useEffect(() => {
    const wrap = wrapRef.current;
    const img = imgRef.current;
    if (!wrap || !img || prefersReducedMotion()) return;

    let trigger: ScrollTrigger | null = null;

    const ctx = gsap.context(() => {
      if (direction === 'zoom') {
        gsap.set(img, { scale: 1.25, transformOrigin: 'center center' });
        const tween = gsap.to(img, {
          scale: 1,
          ease: 'none',
          scrollTrigger: { trigger: wrap, start: 'top bottom', end: 'bottom top', scrub: true },
        });
        trigger = tween.scrollTrigger ?? null;
        return;
      }

      const from = direction === 'lr' ? -amount : amount;
      /* Oversize so the drift never exposes an edge. */
      gsap.set(img, { width: `calc(100% + ${amount * 2}px)`, x: from });

      const tween = gsap.to(img, {
        x: -from,
        ease: 'none',
        scrollTrigger: { trigger: wrap, start: 'top bottom', end: 'bottom top', scrub: true },
      });
      trigger = tween.scrollTrigger ?? null;
    }, wrap);

    return () => {
      trigger?.kill();
      ctx.revert();
    };
  }, [direction, amount, src]);

  return (
    <div ref={wrapRef} className={cn('img-move-wrap', className)}>
      <img ref={imgRef} src={src} alt={alt} className={imgClassName} loading="lazy" />
      {children}
    </div>
  );
}

import { useEffect, useRef } from 'react';
import { prefersReducedMotion } from '@/lib/gsap';

/*
  Two-part pointer: a hollow ring plus a smaller filled dot. Both track
  the mouse; hovering a link or button grows the inner dot.
*/
export function CustomCursor() {
  const ringRef = useRef<HTMLDivElement>(null);
  const dotRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (prefersReducedMotion()) return;
    if (!window.matchMedia('(pointer: fine)').matches) return;

    const ring = ringRef.current;
    const dot = dotRef.current;
    if (!ring || !dot) return;

    document.documentElement.classList.add('yt-has-cursor');

    const move = (e: MouseEvent) => {
      const x = `${e.clientX}px`;
      const y = `${e.clientY}px`;
      ring.style.left = x;
      ring.style.top = y;
      dot.style.left = x;
      dot.style.top = y;
    };

    const over = (e: MouseEvent) => {
      const target = e.target as HTMLElement | null;
      const interactive = Boolean(
        target?.closest('a, button, [role="button"], input, textarea, select, label'),
      );
      ring.classList.toggle('custom-cursor__hover', interactive);
      dot.classList.toggle('custom-cursor__innerhover', interactive);
    };

    window.addEventListener('mousemove', move, { passive: true });
    window.addEventListener('mouseover', over, { passive: true });

    return () => {
      document.documentElement.classList.remove('yt-has-cursor');
      window.removeEventListener('mousemove', move);
      window.removeEventListener('mouseover', over);
    };
  }, []);

  return (
    <>
      <div className="custom-cursor__cursor" ref={ringRef} aria-hidden />
      <div className="custom-cursor__cursor-two" ref={dotRef} aria-hidden />
    </>
  );
}

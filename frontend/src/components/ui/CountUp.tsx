import { useEffect, useRef, useState } from 'react';
import { useInView } from 'framer-motion';
import { formatNumber } from '@/utils/cn';

interface CountUpProps {
  value: string | number;
  suffix?: string | null;
  duration?: number;
  className?: string;
}

export function CountUp({ value, suffix = '', duration = 1.8, className }: CountUpProps) {
  const ref = useRef<HTMLSpanElement>(null);
  const isInView = useInView(ref, { once: true, amount: 0.35 });
  const [display, setDisplay] = useState('0');

  const raw = typeof value === 'string' ? value.replace(/,/g, '') : String(value);
  const numeric = parseFloat(raw);
  const isNumeric = !Number.isNaN(numeric);

  useEffect(() => {
    if (!isInView) return;

    if (!isNumeric) {
      setDisplay(String(value));
      return;
    }

    const startTime = performance.now();
    let frame = 0;

    const tick = (now: number) => {
      const progress = Math.min((now - startTime) / (duration * 1000), 1);
      const eased = 1 - (1 - progress) ** 3;
      const current = Math.floor(eased * numeric);
      setDisplay(formatNumber(current));
      if (progress < 1) frame = requestAnimationFrame(tick);
      else setDisplay(formatNumber(numeric));
    };

    frame = requestAnimationFrame(tick);
    return () => cancelAnimationFrame(frame);
  }, [isInView, isNumeric, numeric, value, duration]);

  return (
    <span ref={ref} className={className}>
      {display}
      {suffix}
    </span>
  );
}

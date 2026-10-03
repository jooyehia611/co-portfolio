import { cn } from '@/utils/cn';

interface MarqueeProps {
  items: string[];
  className?: string;
  /* Seconds for one full loop. */
  speed?: number;
}

/*
  Two counter-rotating bands that cross each other: a light band skewed
  one way, an accent band skewed the other and layered on top.
*/
export function Marquee({ items, className, speed = 20 }: MarqueeProps) {
  if (items.length === 0) return null;

  /* Doubling the list is what makes the -50% translate loop seamlessly. */
  const track = [...items, ...items];

  return (
    <section className={cn('slide-text', className)} aria-hidden dir="ltr">
      <div className="slide-text__one">
        <div
          className="slide-text__scroll slide-text__scroll--left"
          style={{ animationDuration: `${speed}s` }}
        >
          {track.map((item, i) => (
            <span className="slide-text__title" key={`a-${i}`}>
              <span className="slide-text__star">*</span>
              {item}
            </span>
          ))}
        </div>
      </div>
      <div className="slide-text__two">
        <div
          className="slide-text__scroll slide-text__scroll--right"
          style={{ animationDuration: `${speed}s` }}
        >
          {track.map((item, i) => (
            <span className="slide-text__title" key={`b-${i}`}>
              <span className="slide-text__star">*</span>
              {item}
            </span>
          ))}
        </div>
      </div>
    </section>
  );
}

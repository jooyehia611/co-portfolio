import { SplitReveal } from '@/components/ui/SplitReveal';
import { cn } from '@/utils/cn';

interface SectionTitleProps {
  tagline?: string | null;
  title: string;
  /* Italic trailing clause, as used on the reference headings. */
  titleAccent?: string | null;
  text?: string | null;
  align?: 'left' | 'center';
  className?: string;
  as?: 'h1' | 'h2';
}

/* The arrow-and-dots motif that precedes every tagline. */
function TitleShape({ mirrored = false }: { mirrored?: boolean }) {
  return (
    <div className={cn('sec-title__shape', mirrored && 'sec-title__shape--2')} aria-hidden>
      <div className="sec-title__shape__inner" />
    </div>
  );
}

export function SectionTitle({
  tagline,
  title,
  titleAccent,
  text,
  align = 'left',
  className,
  as = 'h2',
}: SectionTitleProps) {
  const centered = align === 'center';

  return (
    <div className={cn('sec-title', centered && 'sec-title--center', className)}>
      {tagline && (
        <div className="sec-title__top">
          <TitleShape />
          <SplitReveal as="p" className="sec-title__tagline" accent>
            {tagline}
          </SplitReveal>
          {centered && <TitleShape mirrored />}
        </div>
      )}

      <SplitReveal as={as} className="sec-title__title">
        {title}
        {titleAccent && <span className="sec-title__title__text"> {titleAccent}</span>}
      </SplitReveal>

      {text && <p className="sec-title__text">{text}</p>}
    </div>
  );
}

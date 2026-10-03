import { useI18n } from '@/i18n';
import { Button } from '@/components/ui/Button';
import { SplitReveal } from '@/components/ui/SplitReveal';

interface FinalCTASectionProps {
  eyebrow?: string | null;
  title: string;
  description?: string | null;
  buttonLabel: string;
  buttonHref: string;
  secondaryLabel?: string | null;
  secondaryHref?: string | null;
}

export function FinalCTASection({
  eyebrow,
  title,
  description,
  buttonLabel,
  buttonHref,
  secondaryLabel,
  secondaryHref,
}: FinalCTASectionProps) {
  const { localizedPath } = useI18n();

  return (
    <section className="cta-one">
      <div className="container-site">
        <div className="cta-one__inner">
          <div className="cta-one__glow" aria-hidden />

          {eyebrow && <p className="cta-one__eyebrow">{eyebrow}</p>}

          <SplitReveal as="h2" className="cta-one__title">
            {title}
          </SplitReveal>

          {description && <p className="cta-one__text">{description}</p>}

          <div className="cta-one__actions">
            <Button href={localizedPath(buttonHref)}>{buttonLabel}</Button>
            {secondaryLabel && secondaryHref && (
              <Button href={localizedPath(secondaryHref)} variant="outline">
                {secondaryLabel}
              </Button>
            )}
          </div>
        </div>
      </div>
    </section>
  );
}

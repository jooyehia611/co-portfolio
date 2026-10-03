import { SectionTitle } from '@/components/ui/SectionTitle';
import { serviceIcon } from '@/utils/serviceIcons';
import type { BusinessValue } from '@/types/shared';

interface BusinessValueSectionProps {
  tagline?: string | null;
  title: string;
  text?: string | null;
  values: BusinessValue[];
}

export function BusinessValueSection({
  tagline,
  title,
  text,
  values,
}: BusinessValueSectionProps) {
  if (values.length === 0) return null;

  return (
    <section className="values-one section-space">
      <div className="container-site">
        <SectionTitle tagline={tagline} title={title} text={text} align="center" />

        <div className="values-one__grid">
          {values.map((value, index) => {
            const Icon = serviceIcon(value.icon, index);
            return (
              <article className="value-card" key={value.id}>
                <span className="value-card__icon" aria-hidden>
                  <Icon size={24} />
                </span>
                <h3 className="value-card__title">{value.title}</h3>
                <p className="value-card__text">{value.description}</p>
              </article>
            );
          })}
        </div>
      </div>
    </section>
  );
}

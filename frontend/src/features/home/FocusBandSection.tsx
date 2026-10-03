import { SectionTitle } from '@/components/ui/SectionTitle';
import { ParallaxImage } from '@/components/ui/ParallaxImage';
import type { FocusArea } from '@/types/home';

interface FocusBandSectionProps {
  tagline?: string | null;
  title: string;
  text?: string | null;
  items: FocusArea[];
  imageUrl?: string | null;
}

function FocusItemsColumn({
  items,
  startIndex,
}: {
  items: FocusArea[];
  startIndex: number;
}) {
  return (
    <ul className="focus-band__items">
      {items.map((item, index) => (
        <li className="focus-band__item" key={`${item.title}-${startIndex + index}`}>
          <h3 className="focus-band__item__title">
            <span className="focus-band__item__index">
              {String(startIndex + index + 1).padStart(2, '0')}
            </span>
            {item.title}
          </h3>
          <p className="focus-band__item__text">{item.description}</p>
        </li>
      ))}
    </ul>
  );
}

export function FocusBandSection({
  tagline,
  title,
  text,
  items,
  imageUrl,
}: FocusBandSectionProps) {
  if (items.length === 0) return null;

  const mid = Math.ceil(items.length / 2);
  const leftItems = items.slice(0, mid);
  const rightItems = items.slice(mid);

  return (
    <section className="focus-band section-space">
      <div className="container-site">
        <div className="focus-band__grid">
          <div>
            {imageUrl ? (
              <ParallaxImage
                src={imageUrl}
                alt={title}
                className="focus-band__image"
                direction="zoom"
              />
            ) : null}
          </div>

          <div>
            <SectionTitle tagline={tagline} title={title} text={text} />

            <div className="focus-band__columns">
              <FocusItemsColumn items={leftItems} startIndex={0} />
              {rightItems.length > 0 && (
                <FocusItemsColumn items={rightItems} startIndex={mid} />
              )}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

import type { CSSProperties } from 'react';
import { Globe } from 'lucide-react';
import { brandIcons, type BrandKey } from '@/components/ui/BrandIcons';
import type { Settings } from '@/types/shared';
import { cn } from '@/utils/cn';

interface SocialLinksProps {
  social?: Settings['social'] | null;
  className?: string;
  style?: CSSProperties;
  size?: number;
}

const labels: Record<string, string> = {
  facebook: 'Facebook',
  twitter: 'X',
  linkedin: 'LinkedIn',
  instagram: 'Instagram',
  github: 'GitHub',
  behance: 'Behance',
  dribbble: 'Dribbble',
};

export function SocialLinks({ social, className, style, size = 16 }: SocialLinksProps) {
  const entries = social
    ? (Object.entries(social).filter(([, url]) => Boolean(url)) as [string, string][])
    : [];

  if (entries.length === 0) return null;

  return (
    <ul className={cn(className)} style={style}>
      {entries.map(([key, url]) => {
        const Icon = brandIcons[key as BrandKey] ?? Globe;
        return (
          <li key={key}>
            <a
              href={url}
              target="_blank"
              rel="noopener noreferrer"
              aria-label={labels[key] ?? key}
            >
              <Icon size={size} />
            </a>
          </li>
        );
      })}
    </ul>
  );
}

import { cn } from '@/utils/cn';
import type { MediaFile } from '@/types/api';

interface BrandLogoProps {
  logo?: MediaFile | null;
  companyName: string;
  variant?: 'header' | 'footer';
  className?: string;
}

export function BrandLogo({
  logo,
  companyName,
  variant = 'header',
  className,
}: BrandLogoProps) {
  return (
    <img
      src={logo?.url || '/logo.png'}
      alt={logo?.alt_text || companyName}
      className={cn('brand-logo', className)}
      style={{ height: variant === 'header' ? 72 : 68, width: 'auto', maxWidth: 'none' }}
    />
  );
}

import type { ReactNode } from 'react';

interface FloatingCardProps {
  variant: 'grow' | 'idea';
  title: string;
  subtitle: string;
  icon: ReactNode;
}

export function FloatingCard({ variant, title, subtitle, icon }: FloatingCardProps) {
  return (
    <article className={`hero-pro__float hero-pro__float--${variant}`}>
      <span className="hero-pro__float-icon" aria-hidden>
        {icon}
      </span>
      <p>
        {title}
        <strong>{subtitle}</strong>
      </p>
    </article>
  );
}

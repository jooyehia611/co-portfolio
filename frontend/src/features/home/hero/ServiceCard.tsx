import { Link } from 'react-router-dom';
import type { LucideIcon } from 'lucide-react';

interface ServiceCardProps {
  icon: LucideIcon;
  label: string;
  href?: string;
  delay?: string;
}

export function ServiceCard({ icon: Icon, label, href, delay }: ServiceCardProps) {
  const style = delay ? { animationDelay: delay } : undefined;
  const inner = (
    <>
      <span>
        <Icon size={22} strokeWidth={1.8} />
      </span>
      {label}
    </>
  );

  if (href) {
    return (
      <li className="hero-pro__service" style={style}>
        <Link to={href} className="hero-pro__service-link">
          {inner}
        </Link>
      </li>
    );
  }

  return (
    <li className="hero-pro__service" style={style}>
      {inner}
    </li>
  );
}

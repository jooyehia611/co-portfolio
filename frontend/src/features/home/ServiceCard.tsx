import { Link } from 'react-router-dom';
import { ArrowUpRight } from 'lucide-react';
import { useI18n } from '@/i18n';
import { serviceIcon } from '@/utils/serviceIcons';
import type { Service } from '@/types/service';

interface ServiceCardProps {
  service: Service;
  index: number;
}

function ServiceCardShape() {
  return (
    <svg className="service-card__shape" viewBox="0 0 132 88" fill="none" aria-hidden>
      <path
        d="M10 78c18-28 38-48 68-54 24-5 42 6 48 26"
        stroke="currentColor"
        strokeWidth="16"
        strokeLinecap="round"
      />
      <circle cx="108" cy="22" r="10" fill="currentColor" />
    </svg>
  );
}

export function ServiceCard({ service, index }: ServiceCardProps) {
  const { t, localizedPath } = useI18n();
  const Icon = serviceIcon(service.icon, index);
  const href = localizedPath(`/services/${service.slug}`);
  const cover = service.cover?.url;

  return (
    <Link to={href} className="service-card" aria-label={service.title}>
      <div className="service-card__hover" aria-hidden>
        <span className="service-card__hover__bg service-card__hover__bg--1" />
        <span className="service-card__hover__bg service-card__hover__bg--2" />
        <span className="service-card__hover__bg service-card__hover__bg--3" />
        <span className="service-card__hover__bg service-card__hover__bg--4" />
      </div>

      <div className="service-card__content">
        <p className="service-card__serial">
          <span className="service-card__serial__shape" aria-hidden />
          {t('home.serviceLabel')} {String(index + 1).padStart(2, '0')}
        </p>

        <h3 className="service-card__title">{service.title}</h3>

        <div className="service-card__image">
          <ServiceCardShape />
          {cover && (
            <img
              className="service-card__image__main"
              src={cover}
              alt=""
              loading="lazy"
            />
          )}
        </div>

        <div className="service-card__icon-box" aria-hidden>
          <span className="service-card__icon">
            <Icon size={40} strokeWidth={1.4} />
          </span>
        </div>
      </div>

      <span className="service-card__btn" aria-hidden>
        <span className="service-card__btn__icon">
          <ArrowUpRight size={12} />
        </span>
      </span>
    </Link>
  );
}

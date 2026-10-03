import { useEffect, useState } from 'react';
import { useI18n } from '@/i18n';
import { fetchServices } from '@/services/servicesService';
import type { Service } from '@/types/service';

/*
  Services power the header dropdown and several sidebars, so the list is
  cached per locale to avoid refetching on every mount.
*/
const cache = new Map<string, Service[]>();

export function useServicesList(): Service[] {
  const { locale } = useI18n();
  const [services, setServices] = useState<Service[]>(() => cache.get(locale) ?? []);

  useEffect(() => {
    const cached = cache.get(locale);
    if (cached) {
      setServices(cached);
      return;
    }

    let active = true;
    fetchServices()
      .then((list) => {
        cache.set(locale, list);
        if (active) setServices(list);
      })
      .catch(() => {
        if (active) setServices([]);
      });

    return () => {
      active = false;
    };
  }, [locale]);

  return services;
}

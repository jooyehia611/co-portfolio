import { useEffect, useState } from 'react';
import { useI18n } from '@/i18n';

export function useLocaleData<T>(
  loader: () => Promise<T>,
  deps: unknown[] = [],
) {
  const { locale } = useI18n();
  const [data, setData] = useState<T | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    let active = true;
    setLoading(true);

    loader()
      .then((result) => {
        if (active) setData(result);
      })
      .catch(() => {
        if (active) setData(null);
      })
      .finally(() => {
        if (active) setLoading(false);
      });

    return () => {
      active = false;
    };
    // locale triggers re-fetch; extra deps e.g. slug
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [locale, ...deps]);

  return { data, loading, locale };
}

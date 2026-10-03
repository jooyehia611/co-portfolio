import { createContext, useContext, useMemo, type ReactNode } from 'react';
import { useParams } from 'react-router-dom';
import { setApiLocale } from '@/api/client';
import type { Locale } from '@/types/api';
import en from './locales/en.json';
import ar from './locales/ar.json';

const translations = { en, ar } as const;

type TranslationKey = string;

interface I18nContextValue {
  locale: Locale;
  t: (key: TranslationKey) => string;
  dir: 'ltr' | 'rtl';
  localizedPath: (path: string) => string;
}

const I18nContext = createContext<I18nContextValue | null>(null);

function getNestedValue(obj: Record<string, unknown>, path: string): string {
  const keys = path.split('.');
  let current: unknown = obj;
  for (const key of keys) {
    if (current && typeof current === 'object' && key in current) {
      current = (current as Record<string, unknown>)[key];
    } else {
      return path;
    }
  }
  return typeof current === 'string' ? current : path;
}

export function I18nProvider({ children }: { children: ReactNode }) {
  const { locale: localeParam } = useParams<{ locale: string }>();
  const locale: Locale = localeParam === 'ar' ? 'ar' : 'en';

  setApiLocale(locale);

  const value = useMemo<I18nContextValue>(() => ({
    locale,
    dir: locale === 'ar' ? 'rtl' : 'ltr',
    t: (key: TranslationKey) => getNestedValue(translations[locale] as Record<string, unknown>, key),
    localizedPath: (path: string) => {
      const clean = path.startsWith('/') ? path : `/${path}`;
      return `/${locale}${clean === '/' ? '' : clean}`;
    },
  }), [locale]);

  return <I18nContext.Provider value={value}>{children}</I18nContext.Provider>;
}

export function useI18n() {
  const ctx = useContext(I18nContext);
  if (!ctx) throw new Error('useI18n must be used within I18nProvider');
  return ctx;
}

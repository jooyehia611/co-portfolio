import { createContext, useContext, useEffect, useState, type ReactNode } from 'react';
import { useParams } from 'react-router-dom';
import { fetchSettings } from '@/services/settingsService';
import type { Locale } from '@/types/api';
import type { Settings } from '@/types/shared';

interface SettingsContextValue {
  settings: Settings | null;
  loading: boolean;
}

const SettingsContext = createContext<SettingsContextValue>({
  settings: null,
  loading: true,
});

export function SettingsProvider({ children }: { children: ReactNode }) {
  const { locale: localeParam } = useParams<{ locale: string }>();
  const locale: Locale = localeParam === 'ar' ? 'ar' : 'en';
  const [settings, setSettings] = useState<Settings | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    setLoading(true);
    fetchSettings()
      .then(setSettings)
      .catch(() => setSettings(null))
      .finally(() => setLoading(false));
  }, [locale]);

  return (
    <SettingsContext.Provider value={{ settings, loading }}>
      {children}
    </SettingsContext.Provider>
  );
}

export function useSettings() {
  return useContext(SettingsContext);
}

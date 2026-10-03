import { useEffect } from 'react';
import { Helmet } from 'react-helmet-async';
import { useSettings } from '@/hooks/useSettings';

export function SiteBranding() {
  const { settings } = useSettings();

  useEffect(() => {
    if (settings?.favicon?.url) {
      const link =
        document.querySelector<HTMLLinkElement>("link[rel='icon']") ??
        document.createElement('link');
      link.rel = 'icon';
      link.type = settings.favicon.mime_type || 'image/svg+xml';
      link.href = settings.favicon.url;
      if (!link.parentElement) {
        document.head.appendChild(link);
      }
    }
  }, [settings?.favicon?.url, settings?.favicon?.mime_type]);

  return (
    <Helmet>
      {settings?.favicon?.url && (
        <link rel="icon" type={settings.favicon.mime_type || 'image/svg+xml'} href={settings.favicon.url} />
      )}
    </Helmet>
  );
}

import { Outlet } from 'react-router-dom';
import { useEffect } from 'react';
import { I18nProvider, useI18n } from '@/i18n';
import { SettingsProvider } from '@/hooks/useSettings';
import { ContentGateProvider } from '@/hooks/useContentGate';
import { useSmoothScroll } from '@/hooks/useSmoothScroll';
import { Navbar } from '@/components/layout/Navbar';
import { Footer } from '@/components/layout/Footer';
import { SiteBranding } from '@/components/layout/SiteBranding';
import { ScrollToTop } from '@/components/layout/ScrollToTop';
import { CustomCursor } from '@/components/ui/CustomCursor';

function LayoutContent() {
  const { dir } = useI18n();

  useEffect(() => {
    document.documentElement.dir = dir;
    document.documentElement.lang = dir === 'rtl' ? 'ar' : 'en';
    document.documentElement.setAttribute('data-theme', 'dark');
  }, [dir]);

  useSmoothScroll();

  return (
    <div className="site-shell">
      <SiteBranding />

      {/* Header stays outside the smoothed content so it can stay fixed. */}
      <Navbar />

      <div id="smooth-wrapper">
        <div id="smooth-content">
          <main className="site-shell__main">
            <Outlet />
          </main>
          <Footer />
        </div>
      </div>

      <ScrollToTop />
      <CustomCursor />
    </div>
  );
}

export function MainLayout() {
  return (
    <I18nProvider>
      <SettingsProvider>
        <ContentGateProvider>
          <LayoutContent />
        </ContentGateProvider>
      </SettingsProvider>
    </I18nProvider>
  );
}

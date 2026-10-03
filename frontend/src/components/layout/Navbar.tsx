import { useEffect, useState } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { ArrowRight, ChevronDown, ChevronRight, Mail, MapPin, PhoneCall, X } from 'lucide-react';
import { useI18n } from '@/i18n';
import { useSettings } from '@/hooks/useSettings';
import { useServicesList } from '@/hooks/useServicesList';
import { BrandLogo } from '@/components/ui/BrandLogo';
import { SocialLinks } from '@/components/ui/SocialLinks';
import { cn } from '@/utils/cn';

interface NavItem {
  key: string;
  path: string;
  children?: { label: string; path: string }[];
}

export function Navbar() {
  const { t, localizedPath, locale } = useI18n();
  const { settings } = useSettings();
  const services = useServicesList();
  const location = useLocation();

  const [scrolled, setScrolled] = useState(false);
  const [panelOpen, setPanelOpen] = useState(false);
  const [drawerOpen, setDrawerOpen] = useState(false);
  const [openSub, setOpenSub] = useState<string | null>(null);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 8);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  /* Any navigation closes whatever was open. */
  useEffect(() => {
    setPanelOpen(false);
    setDrawerOpen(false);
    setOpenSub(null);
  }, [location.pathname]);

  useEffect(() => {
    const onKey = (e: KeyboardEvent) => {
      if (e.key !== 'Escape') return;
      setPanelOpen(false);
      setDrawerOpen(false);
    };
    window.addEventListener('keydown', onKey);
    return () => window.removeEventListener('keydown', onKey);
  }, []);

  /* Lock the page behind either overlay. */
  useEffect(() => {
    const locked = panelOpen || drawerOpen;
    document.body.style.overflow = locked ? 'hidden' : '';
    return () => {
      document.body.style.overflow = '';
    };
  }, [panelOpen, drawerOpen]);

  const navItems: NavItem[] = [
    { key: 'nav.home', path: '/' },
    {
      key: 'nav.services',
      path: '/services',
      children: services.map((s) => ({ label: s.title, path: `/services/${s.slug}` })),
    },
    { key: 'nav.work', path: '/work' },
    { key: 'nav.about', path: '/about' },
    { key: 'nav.contact', path: '/contact' },
  ];

  const switchLocale = locale === 'en' ? 'ar' : 'en';
  const switchPath = location.pathname.replace(`/${locale}`, `/${switchLocale}`);

  const isActive = (path: string) => {
    const full = localizedPath(path);
    if (path === '/') return location.pathname === full || location.pathname === `${full}/`;
    return location.pathname.startsWith(full);
  };

  const companyName = settings?.company_name || 'Ytech';

  return (
    <>
      <header className={cn('main-header', scrolled && 'is-solid')}>
        <div className="container-site">
          <div className="main-header__inner">
            <Link to={localizedPath('/')} className="main-header__logo" aria-label={companyName}>
              <BrandLogo logo={settings?.logo} companyName={companyName} variant="header" />
            </Link>

            <div className="main-header__spacer" aria-hidden />

            <nav className="main-menu" aria-label="Primary">
              <ul className="main-menu__list">
                {navItems.map((item) => {
                  const hasChildren = Boolean(item.children?.length);
                  return (
                    <li key={item.path} className={cn(isActive(item.path) && 'is-active')}>
                      <Link to={localizedPath(item.path)}>
                        {t(item.key)}
                        {hasChildren && (
                          <span className="main-menu__caret" aria-hidden>
                            <ChevronDown size={15} strokeWidth={2.5} />
                          </span>
                        )}
                      </Link>
                      {hasChildren && (
                        <ul className="main-menu__dropdown">
                          {item.children!.map((child) => (
                            <li key={child.path}>
                              <Link to={localizedPath(child.path)}>{child.label}</Link>
                            </li>
                          ))}
                        </ul>
                      )}
                    </li>
                  );
                })}
              </ul>
            </nav>

            <div className="main-header__spacer" aria-hidden />

            <div className="main-header__end">
              <div className="main-header__right">
                {settings?.phone && (
                  <a
                    href={`tel:${settings.phone.replace(/\s/g, '')}`}
                    className="main-header__phone"
                    aria-label={settings.phone}
                    title={settings.phone}
                  >
                    <span className="main-header__phone__icon" aria-hidden>
                      <PhoneCall size={17} />
                    </span>
                    <span className="main-header__phone__number">{settings.phone}</span>
                  </a>
                )}

                <Link to={localizedPath('/contact')} className="main-header__cta" dir={locale === 'ar' ? 'rtl' : 'ltr'}>
                  {t('nav.startProject')}
                  <ArrowRight size={16} strokeWidth={2.4} />
                </Link>

                <button
                  type="button"
                  className="mobile-nav__btn"
                  onClick={() => setDrawerOpen(true)}
                  aria-label={t('nav.openMenu')}
                  aria-expanded={drawerOpen}
                >
                  <span />
                  <span />
                  <span />
                </button>

                <button
                  type="button"
                  className="sidebar-btn"
                  onClick={() => setPanelOpen(true)}
                  aria-label={t('nav.openPanel')}
                  aria-expanded={panelOpen}
                >
                  <span className="sidebar-btn__line" />
                  <span className="sidebar-btn__line" />
                  <span className="sidebar-btn__line" />
                </button>
              </div>

              <Link
                to={switchPath}
                className="main-header__lang"
                hrefLang={switchLocale}
                aria-label={switchLocale === 'ar' ? 'العربية' : 'English'}
              >
                {switchLocale === 'ar' ? 'ع' : 'EN'}
              </Link>
            </div>
          </div>
        </div>
      </header>

      {/* Offcanvas company panel */}
      <div className={cn('offcanvas-panel', panelOpen && 'is-open')}>
        <div
          className="offcanvas-panel__overlay"
          onClick={() => setPanelOpen(false)}
          aria-hidden
        />
        <div className="offcanvas-panel__content" role="dialog" aria-modal={panelOpen}>
          <button
            type="button"
            className="offcanvas-panel__close"
            onClick={() => setPanelOpen(false)}
            aria-label={t('nav.close')}
          >
            <X size={18} />
          </button>

          <div className="offcanvas-panel__logo">
            <BrandLogo logo={settings?.logo} companyName={companyName} variant="footer" />
          </div>

          {settings?.footer_text && (
            <p className="offcanvas-panel__text">{settings.footer_text}</p>
          )}

          <h3 className="offcanvas-panel__title">{t('footer.contact')}</h3>
          <ul className="offcanvas-panel__contact">
            {settings?.email && (
              <li>
                <span className="offcanvas-panel__contact-icon" aria-hidden>
                  <Mail size={15} />
                </span>
                <a href={`mailto:${settings.email}`}>{settings.email}</a>
              </li>
            )}
            {settings?.phone && (
              <li>
                <span className="offcanvas-panel__contact-icon" aria-hidden>
                  <PhoneCall size={15} />
                </span>
                <a href={`tel:${settings.phone.replace(/\s/g, '')}`} dir="ltr">
                  {settings.phone}
                </a>
              </li>
            )}
            {settings?.address && (
              <li>
                <span className="offcanvas-panel__contact-icon" aria-hidden>
                  <MapPin size={15} />
                </span>
                <span>{settings.address}</span>
              </li>
            )}
          </ul>

          <SocialLinks social={settings?.social} className="offcanvas-panel__socials" />
        </div>
      </div>

      {/* Mobile drawer */}
      <div className={cn('mobile-nav', drawerOpen && 'is-open')}>
        <div className="mobile-nav__overlay" onClick={() => setDrawerOpen(false)} aria-hidden />
        <div className="mobile-nav__content" role="dialog" aria-modal={drawerOpen}>
          <button
            type="button"
            className="offcanvas-panel__close"
            onClick={() => setDrawerOpen(false)}
            aria-label={t('nav.close')}
          >
            <X size={18} />
          </button>

          <BrandLogo logo={settings?.logo} companyName={companyName} variant="footer" />

          <ul className="mobile-nav__list">
            {navItems.map((item) => {
              const hasChildren = Boolean(item.children?.length);
              const subOpen = openSub === item.path;
              return (
                <li key={item.path}>
                  {hasChildren ? (
                    <>
                      <button
                        type="button"
                        onClick={() => setOpenSub(subOpen ? null : item.path)}
                        aria-expanded={subOpen}
                      >
                        {t(item.key)}
                        <ChevronDown
                          size={16}
                          style={{ transform: subOpen ? 'rotate(180deg)' : undefined }}
                        />
                      </button>
                      <ul className={cn('mobile-nav__sub', subOpen && 'is-open')}>
                        <li>
                          <Link to={localizedPath(item.path)}>{t('nav.allServices')}</Link>
                        </li>
                        {item.children!.map((child) => (
                          <li key={child.path}>
                            <Link to={localizedPath(child.path)}>{child.label}</Link>
                          </li>
                        ))}
                      </ul>
                    </>
                  ) : (
                    <Link to={localizedPath(item.path)}>
                      {t(item.key)}
                      <ChevronRight size={16} />
                    </Link>
                  )}
                </li>
              );
            })}
          </ul>

          <SocialLinks
            social={settings?.social}
            className="offcanvas-panel__socials"
            style={{ marginTop: 30 }}
          />
        </div>
      </div>
    </>
  );
}

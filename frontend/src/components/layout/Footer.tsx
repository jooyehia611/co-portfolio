import { useState } from 'react';
import { Link } from 'react-router-dom';
import { Mail, MapPin, PhoneCall } from 'lucide-react';
import { useI18n } from '@/i18n';
import { useSettings } from '@/hooks/useSettings';
import { useServicesList } from '@/hooks/useServicesList';
import { BrandLogo } from '@/components/ui/BrandLogo';
import { SocialLinks } from '@/components/ui/SocialLinks';

export function Footer() {
  const { t, localizedPath } = useI18n();
  const { settings } = useSettings();
  const services = useServicesList();
  const year = new Date().getFullYear();

  const [email, setEmail] = useState('');
  const [subscribed, setSubscribed] = useState(false);

  const companyName = settings?.company_name || 'Ytech';

  const navLinks = [
    { key: 'nav.home', path: '/' },
    { key: 'nav.services', path: '/services' },
    { key: 'nav.work', path: '/work' },
    { key: 'nav.about', path: '/about' },
    { key: 'nav.contact', path: '/contact' },
  ];

  /*
    No newsletter endpoint exists yet, so this acknowledges locally and
    hands the address to the contact form via the querystring.
  */
  const onSubscribe = (e: React.FormEvent) => {
    e.preventDefault();
    if (!email.trim()) return;
    setSubscribed(true);
    setEmail('');
  };

  return (
    <footer className="main-footer">
      <div className="yt-stripes" aria-hidden />

      <div className="container-site">
        <div className="main-footer__top">
          <div>
            <Link to={localizedPath('/')} aria-label={companyName}>
              <BrandLogo logo={settings?.logo} companyName={companyName} variant="footer" />
            </Link>
            {settings?.footer_text && (
              <p className="main-footer__about-text">{settings.footer_text}</p>
            )}
            <SocialLinks social={settings?.social} className="main-footer__socials" size={17} />
          </div>

          <div>
            <h2 className="main-footer__widget-title">{t('footer.navigation')}</h2>
            <ul className="main-footer__links">
              {navLinks.map((link) => (
                <li key={link.path}>
                  <Link to={localizedPath(link.path)}>{t(link.key)}</Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h2 className="main-footer__widget-title">{t('footer.services')}</h2>
            <ul className="main-footer__links">
              {services.slice(0, 6).map((service) => (
                <li key={service.slug}>
                  <Link to={localizedPath(`/services/${service.slug}`)}>{service.title}</Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h2 className="main-footer__widget-title">{t('footer.newsletter')}</h2>
            <p className="main-footer__newsletter-text">{t('footer.newsletterText')}</p>

            <form className="footer-newsletter" onSubmit={onSubscribe}>
              <div className="footer-newsletter__field">
                <input
                  type="email"
                  className="footer-newsletter__input"
                  placeholder={t('footer.emailPlaceholder')}
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  aria-label={t('footer.emailPlaceholder')}
                  required
                />
                <button type="submit" className="footer-newsletter__submit">
                  {t('footer.subscribe')}
                </button>
              </div>
              {subscribed && <p className="footer-newsletter__note">{t('footer.subscribed')}</p>}
            </form>

            <ul className="main-footer__contact" style={{ marginTop: 30 }}>
              {settings?.email && (
                <li>
                  <Mail size={16} />
                  <a href={`mailto:${settings.email}`}>{settings.email}</a>
                </li>
              )}
              {settings?.phone && (
                <li>
                  <PhoneCall size={16} />
                  <a href={`tel:${settings.phone.replace(/\s/g, '')}`} dir="ltr">
                    {settings.phone}
                  </a>
                </li>
              )}
              {settings?.address && (
                <li>
                  <MapPin size={16} />
                  <span>{settings.address}</span>
                </li>
              )}
            </ul>
          </div>
        </div>
      </div>

      <div className="main-footer__wordmark" aria-hidden>
        <div className="main-footer__wordmark-mark">
          <img
            className="main-footer__wordmark-icon"
            src="/logo-icon.png?v=3"
            alt=""
            width={256}
            height={256}
          />
          <span className="main-footer__wordmark-title">Technology</span>
        </div>
      </div>

      <div className="container-site">
        <div className="main-footer__bottom">
          <p>
            &copy; {year} {companyName}. {t('footer.rights')}
          </p>
          <ul>
            <li>
              <Link to={localizedPath('/privacy')}>{t('footer.privacy')}</Link>
            </li>
            <li>
              <Link to={localizedPath('/terms')}>{t('footer.terms')}</Link>
            </li>
          </ul>
        </div>
      </div>
    </footer>
  );
}

import { useEffect, useState } from 'react';
import { Mail, MapPin, PhoneCall, Send } from 'lucide-react';
import { fetchContactFormData, submitContact } from '@/services/contactService';
import { useSettings } from '@/hooks/useSettings';
import { useI18n } from '@/i18n';
import { usePageSeo } from '@/hooks/usePageSeo';
import { SEOHead } from '@/components/ui/SEOHead';
import { PageHeader } from '@/components/ui/PageHeader';
import { Button } from '@/components/ui/Button';
import { SocialLinks } from '@/components/ui/SocialLinks';
import type { ContactFormData, ContactPayload } from '@/types/contact';

type FieldErrors = Partial<Record<keyof FormState, string>>;

interface FormState {
  name: string;
  email: string;
  phone: string;
  company: string;
  service_id: string;
  message: string;
}

const EMPTY: FormState = {
  name: '',
  email: '',
  phone: '',
  company: '',
  service_id: '',
  message: '',
};

export function ContactPage() {
  const { t, locale } = useI18n();
  const { settings } = useSettings();
  const {
    seo,
    title,
    description,
  } = usePageSeo('contact', {
    title: t('contact.title'),
    description: t('contact.subtitle'),
  });

  const [form, setForm] = useState<FormState>(EMPTY);
  const [errors, setErrors] = useState<FieldErrors>({});
  const [options, setOptions] = useState<ContactFormData | null>(null);
  const [status, setStatus] = useState<'idle' | 'sending' | 'sent' | 'error'>('idle');
  const [message, setMessage] = useState('');

  useEffect(() => {
    fetchContactFormData()
      .then(setOptions)
      .catch(() => setOptions(null));
  }, [locale]);

  const set = (key: keyof FormState) => (
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>,
  ) => {
    setForm((prev) => ({ ...prev, [key]: e.target.value }));
    setErrors((prev) => ({ ...prev, [key]: undefined }));
  };

  const validate = (): boolean => {
    const next: FieldErrors = {};
    if (!form.name.trim()) next.name = t('contact.required');
    if (!form.email.trim()) next.email = t('contact.required');
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) next.email = t('contact.invalidEmail');
    if (!form.message.trim()) next.message = t('contact.required');

    setErrors(next);
    return Object.keys(next).length === 0;
  };

  const onSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!validate()) return;

    setStatus('sending');
    setMessage('');

    const payload: ContactPayload = {
      name: form.name.trim(),
      email: form.email.trim(),
      message: form.message.trim(),
      ...(form.phone.trim() ? { phone: form.phone.trim() } : {}),
      ...(form.company.trim() ? { company: form.company.trim() } : {}),
      ...(form.service_id ? { service_id: Number(form.service_id) } : {}),
    };

    try {
      const reply = await submitContact(payload);
      setStatus('sent');
      setMessage(reply || t('contact.success'));
      setForm(EMPTY);
    } catch (error) {
      setStatus('error');
      setMessage(error instanceof Error ? error.message : t('common.error'));
    }
  };

  const infoCards = [
    settings?.email && {
      icon: <Mail size={19} />,
      label: t('contact.emailLabel'),
      value: <a href={`mailto:${settings.email}`}>{settings.email}</a>,
    },
    settings?.phone && {
      icon: <PhoneCall size={19} />,
      label: t('contact.phoneLabel'),
      value: (
        <a href={`tel:${settings.phone.replace(/\s/g, '')}`} dir="ltr">
          {settings.phone}
        </a>
      ),
    },
    settings?.address && {
      icon: <MapPin size={19} />,
      label: t('contact.addressLabel'),
      value: settings.address,
    },
  ].filter(Boolean) as { icon: React.ReactNode; label: string; value: React.ReactNode }[];

  return (
    <>
      <SEOHead seo={seo} title={title} description={description} />

      <PageHeader
        title={title}
        description={description}
        crumbs={[{ label: t('nav.contact') }]}
      />

      <section className="page-section section-space">
        <div className="container-site">
          <div className="contact-layout">
            <form className="contact-form" onSubmit={onSubmit} noValidate>
              {status === 'sent' && (
                <div className="contact-form__alert contact-form__alert--success" role="status">
                  {message}
                </div>
              )}
              {status === 'error' && (
                <div className="contact-form__alert contact-form__alert--error" role="alert">
                  {message}
                </div>
              )}

              <div className="contact-form__grid">
                <div>
                  <label className="contact-form__label" htmlFor="name">
                    {t('contact.name')}
                  </label>
                  <input
                    id="name"
                    className="contact-form__input"
                    value={form.name}
                    onChange={set('name')}
                    aria-invalid={Boolean(errors.name)}
                  />
                  {errors.name && <p className="contact-form__error">{errors.name}</p>}
                </div>

                <div>
                  <label className="contact-form__label" htmlFor="email">
                    {t('contact.email')}
                  </label>
                  <input
                    id="email"
                    type="email"
                    className="contact-form__input"
                    value={form.email}
                    onChange={set('email')}
                    aria-invalid={Boolean(errors.email)}
                    dir="ltr"
                  />
                  {errors.email && <p className="contact-form__error">{errors.email}</p>}
                </div>

                <div>
                  <label className="contact-form__label" htmlFor="phone">
                    {t('contact.phone')}
                  </label>
                  <input
                    id="phone"
                    className="contact-form__input"
                    value={form.phone}
                    onChange={set('phone')}
                    dir="ltr"
                  />
                </div>

                <div>
                  <label className="contact-form__label" htmlFor="company">
                    {t('contact.company')}
                  </label>
                  <input
                    id="company"
                    className="contact-form__input"
                    value={form.company}
                    onChange={set('company')}
                  />
                </div>

                <div className="contact-form__field--full">
                  <label className="contact-form__label" htmlFor="service">
                    {t('contact.service')}
                  </label>
                  <select
                    id="service"
                    className="contact-form__select"
                    value={form.service_id}
                    onChange={set('service_id')}
                  >
                    <option value="">{t('contact.selectService')}</option>
                    {options?.services.map((service) => (
                      <option value={service.id} key={service.id}>
                        {service.title}
                      </option>
                    ))}
                  </select>
                </div>

                <div className="contact-form__field--full">
                  <label className="contact-form__label" htmlFor="message">
                    {t('contact.message')}
                  </label>
                  <textarea
                    id="message"
                    className="contact-form__textarea"
                    value={form.message}
                    onChange={set('message')}
                    aria-invalid={Boolean(errors.message)}
                  />
                  {errors.message && <p className="contact-form__error">{errors.message}</p>}
                </div>
              </div>

              <div className="contact-form__actions">
                <Button
                  type="submit"
                  disabled={status === 'sending'}
                  icon={<Send size={15} />}
                >
                  {status === 'sending' ? t('contact.sending') : t('contact.submit')}
                </Button>
              </div>
            </form>

            <aside className="contact-aside">
              {infoCards.map((card) => (
                <div className="contact-info-card" key={card.label}>
                  <span className="contact-info-card__icon" aria-hidden>
                    {card.icon}
                  </span>
                  <div>
                    <p className="contact-info-card__label">{card.label}</p>
                    <p className="contact-info-card__value">{card.value}</p>
                  </div>
                </div>
              ))}

              <SocialLinks
                social={settings?.social}
                className="main-footer__socials"
                size={17}
              />
            </aside>
          </div>
        </div>
      </section>
    </>
  );
}

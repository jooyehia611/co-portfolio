import { fetchPrivacy, fetchTerms } from '@/services/contactService';
import { useLocaleData } from '@/hooks/useLocaleData';
import { useI18n } from '@/i18n';
import { SEOHead } from '@/components/ui/SEOHead';
import { PageHeader } from '@/components/ui/PageHeader';
import { LoadingSpinner } from '@/components/ui/LoadingSpinner';
import type { LegalPage } from '@/types/contact';

function LegalPageContent({
  loader,
  fallbackTitle,
}: {
  loader: () => Promise<LegalPage>;
  fallbackTitle: string;
}) {
  const { t } = useI18n();
  const { data: page, loading } = useLocaleData(loader);

  if (loading) return <LoadingSpinner />;

  const title = page?.title ?? fallbackTitle;

  return (
    <>
      <SEOHead seo={page?.seo} title={`${title} — Ytech`} />

      <PageHeader title={title} crumbs={[{ label: title }]} />

      <section className="page-section section-space">
        <div className="container-site">
          {page?.content ? (
            /* Rich text authored in the CMS editor. */
            <div
              className="prose-dark legal-content"
              dangerouslySetInnerHTML={{ __html: page.content }}
            />
          ) : (
            <p className="empty-state">{t('common.loadFailed')}</p>
          )}
        </div>
      </section>
    </>
  );
}

export function PrivacyPage() {
  const { t } = useI18n();
  return <LegalPageContent loader={fetchPrivacy} fallbackTitle={t('footer.privacy')} />;
}

export function TermsPage() {
  const { t } = useI18n();
  return <LegalPageContent loader={fetchTerms} fallbackTitle={t('footer.terms')} />;
}

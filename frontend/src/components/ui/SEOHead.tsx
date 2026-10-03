import { Helmet } from 'react-helmet-async';
import type { SeoData } from '@/types/api';

interface SEOHeadProps {
  title?: string;
  description?: string;
  seo?: SeoData | null;
  companyName?: string;
  siteTitle?: string | null;
}

export function SEOHead({
  title,
  description,
  seo,
  companyName = 'Ytech',
  siteTitle,
}: SEOHeadProps) {
  const pageTitle =
    title || siteTitle || seo?.title || seo?.meta_title || companyName;
  const pageDesc = seo?.description || seo?.meta_description || description || '';
  const ogImage =
    typeof seo?.og_image === 'string'
      ? seo.og_image
      : seo?.og_image?.url;

  return (
    <Helmet>
      <title>{pageTitle}</title>
      {pageDesc && <meta name="description" content={pageDesc} />}
      {seo?.keywords && <meta name="keywords" content={seo.keywords} />}
      <meta property="og:title" content={pageTitle} />
      {pageDesc && <meta property="og:description" content={pageDesc} />}
      {ogImage && <meta property="og:image" content={ogImage} />}
    </Helmet>
  );
}

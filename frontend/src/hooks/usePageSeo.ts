import { useLocaleData } from '@/hooks/useLocaleData';
import { fetchSeo } from '@/services/seoService';
import type { SeoData } from '@/types/api';

interface PageSeoFallbacks {
  title: string;
  description?: string;
}

export function usePageSeo(pageKey: string, fallbacks: PageSeoFallbacks) {
  const { data, loading } = useLocaleData(() => fetchSeo(pageKey), [pageKey]);

  const seo: SeoData | null = data;
  const title = seo?.page_title?.trim() || fallbacks.title;
  const description = seo?.page_description?.trim() || fallbacks.description || '';

  return { seo, title, description, loading };
}

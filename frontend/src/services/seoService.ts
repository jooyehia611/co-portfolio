import apiClient from '@/api/client';
import { endpoints } from '@/api/endpoints';
import type { ApiResponse, SeoData } from '@/types/api';

export async function fetchSeo(key: string): Promise<SeoData> {
  const { data } = await apiClient.get<ApiResponse<SeoData>>(endpoints.seo(key));
  return data.data;
}

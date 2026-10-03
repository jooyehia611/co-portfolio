import apiClient from '@/api/client';
import { endpoints } from '@/api/endpoints';
import type { ApiResponse } from '@/types/api';
import type { HomeData } from '@/types/home';

export async function fetchHomeData(): Promise<HomeData> {
  const { data } = await apiClient.get<ApiResponse<HomeData>>(endpoints.home);
  return data.data;
}

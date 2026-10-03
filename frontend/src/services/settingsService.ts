import apiClient from '@/api/client';
import { endpoints } from '@/api/endpoints';
import type { ApiResponse } from '@/types/api';
import type { Settings } from '@/types/shared';

export async function fetchSettings(): Promise<Settings> {
  const { data } = await apiClient.get<ApiResponse<Settings>>(endpoints.settings);
  return data.data;
}

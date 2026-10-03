import apiClient from '@/api/client';
import { endpoints } from '@/api/endpoints';
import type { ApiResponse } from '@/types/api';
import type { Service } from '@/types/service';

export async function fetchServices(): Promise<Service[]> {
  const { data } = await apiClient.get<ApiResponse<Service[]>>(endpoints.services);
  return data.data;
}

export async function fetchService(slug: string): Promise<Service> {
  const { data } = await apiClient.get<ApiResponse<Service>>(endpoints.service(slug));
  return data.data;
}

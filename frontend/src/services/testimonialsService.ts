import apiClient from '@/api/client';
import { endpoints } from '@/api/endpoints';
import type { ApiResponse } from '@/types/api';
import type { Testimonial } from '@/types/shared';

export async function fetchTestimonials(): Promise<Testimonial[]> {
  const { data } = await apiClient.get<ApiResponse<Testimonial[]>>(endpoints.testimonials);
  return data.data;
}

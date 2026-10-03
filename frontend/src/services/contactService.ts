import { isAxiosError } from 'axios';
import apiClient from '@/api/client';
import { endpoints } from '@/api/endpoints';
import type { ApiResponse } from '@/types/api';
import type { AboutData, ContactFormData, ContactPayload, LegalPage } from '@/types/contact';

export async function fetchAbout(): Promise<AboutData> {
  const { data } = await apiClient.get<ApiResponse<AboutData>>(endpoints.about);
  return data.data;
}

export async function fetchContactFormData(): Promise<ContactFormData> {
  const { data } = await apiClient.get<ApiResponse<ContactFormData>>(endpoints.contactFormData);
  return data.data;
}

export async function submitContact(payload: ContactPayload): Promise<string> {
  try {
    const { data } = await apiClient.post<ApiResponse<null> & { message: string }>(
      endpoints.contact,
      payload,
    );
    return data.message;
  } catch (error) {
    if (isAxiosError(error) && error.response?.data) {
      const body = error.response.data as { message?: string; errors?: Record<string, string[]> };
      if (body.errors) {
        const firstError = Object.values(body.errors).flat()[0];
        throw new Error(firstError || body.message || 'Validation failed');
      }
      if (body.message) {
        throw new Error(body.message);
      }
    }
    throw error;
  }
}

export async function fetchPrivacy(): Promise<LegalPage> {
  const { data } = await apiClient.get<ApiResponse<LegalPage>>(endpoints.privacy);
  return data.data;
}

export async function fetchTerms(): Promise<LegalPage> {
  const { data } = await apiClient.get<ApiResponse<LegalPage>>(endpoints.terms);
  return data.data;
}

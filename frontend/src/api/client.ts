import axios from 'axios';
import type { Locale } from '@/types/api';

let currentLocale: Locale = 'en';

export function setApiLocale(locale: Locale) {
  currentLocale = locale;
}

export function getApiLocale(): Locale {
  return currentLocale;
}

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api/v1',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
});

apiClient.interceptors.request.use((config) => {
  config.headers['Accept-Language'] = currentLocale;
  return config;
});

export default apiClient;

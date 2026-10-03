import axios from 'axios';
import type { Locale } from '@/types/api';

let currentLocale: Locale = 'en';

export function setApiLocale(locale: Locale) {
  currentLocale = locale;
}

export function getApiLocale(): Locale {
  return currentLocale;
}

const apiBaseUrl =
  import.meta.env.VITE_API_URL ||
  (import.meta.env.PROD
    ? 'https://ytech-portfolio.infinityfreeapp.com/api/v1'
    : 'http://localhost:8000/api/v1');

const apiClient = axios.create({
  baseURL: apiBaseUrl,
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

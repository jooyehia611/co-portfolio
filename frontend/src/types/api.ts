export type Locale = 'en' | 'ar';

export interface ApiResponse<T> {
  success: boolean;
  data: T;
  message?: string;
}

export interface PaginatedResponse<T> {
  success: boolean;
  data: T[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

export interface MediaFile {
  id: number;
  filename: string;
  original_name: string;
  url: string;
  mime_type: string;
  size: number;
  alt_text?: string | null;
}

export interface SeoData {
  page_title?: string | null;
  page_description?: string | null;
  title?: string;
  description?: string;
  keywords?: string | null;
  meta_title?: string;
  meta_description?: string;
  og_image?: MediaFile | string | null;
}

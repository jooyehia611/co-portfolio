import type { MediaFile, SeoData } from './api';
import type { Service } from './service';
import type { Technology } from './shared';

export interface Project {
  id: number;
  title: string;
  slug: string;
  client_name?: string | null;
  year?: number | string | null;
  short_description: string;
  description?: string;
  cover?: MediaFile | null;
  thumbnail?: MediaFile | null;
  website_url?: string | null;
  is_featured: boolean;
  services?: Service[];
  technologies?: Technology[];
  challenge?: string;
  solution?: string;
  approach?: string;
  design_notes?: string;
  development_notes?: string;
  key_features?: Array<{
    title?: string | null;
    points: string[];
  }> | null;
  results?: string[];
  timeline?: string;
  video_url?: string | null;
  gallery?: { id: number; url: string; caption?: string | null }[];
  related_projects?: Project[];
  seo: SeoData;
}

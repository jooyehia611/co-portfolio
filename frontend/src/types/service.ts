import type { MediaFile, SeoData } from './api';
import type { Project } from './project';

export interface Service {
  id: number;
  title: string;
  slug: string;
  icon?: string | null;
  short_description: string;
  full_description?: string;
  cover?: MediaFile | null;
  capabilities?: string[];
  business_problems?: string[];
  is_featured: boolean;
  order: number;
  related_projects?: Project[];
  seo: SeoData;
}

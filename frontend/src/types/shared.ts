import type { MediaFile } from './api';

export interface Settings {
  company_name: string;
  site_title?: string | null;
  tagline?: string | null;
  logo: MediaFile | null;
  favicon: MediaFile | null;
  email: string;
  phone?: string | null;
  whatsapp?: string | null;
  address?: string | null;
  social: {
    linkedin?: string | null;
    twitter?: string | null;
    instagram?: string | null;
    facebook?: string | null;
    behance?: string | null;
    dribbble?: string | null;
    github?: string | null;
  };
  footer_text?: string | null;
  default_og_image: MediaFile | null;
  ui?: {
    view_all?: string;
    explore?: string;
    projects_count?: string;
    services?: string;
  };
}

export interface BusinessValue {
  id: number;
  title: string;
  description: string;
  icon?: string | null;
  sort_order: number;
}

export interface ProcessStep {
  id: number;
  title: string;
  description: string;
  step_number: string;
  icon?: string | null;
  image?: MediaFile | null;
  sort_order: number;
}

export interface Technology {
  id: number;
  name: string;
  logo?: MediaFile | null;
  category: string;
}

export interface Statistic {
  id: number;
  label: string;
  value: string;
  suffix?: string | null;
  icon?: string | null;
  sort_order: number;
}

export interface Testimonial {
  id: number;
  client_name: string;
  company?: string | null;
  position?: string | null;
  photo?: MediaFile | null;
  review: string;
  rating: number;
  audio_url?: string | null;
  audio_duration?: number | null;
}

export interface Award {
  id: number;
  year: string;
  title: string;
  platform?: string | null;
  result?: string | null;
  link_url?: string | null;
  logo?: MediaFile | null;
  sort_order: number;
}

export interface TeamMember {
  id: number;
  name: string;
  position: string;
  bio: string;
  photo?: MediaFile | null;
  linkedin_url?: string | null;
  github_url?: string | null;
}

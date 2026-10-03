import type { SeoData } from './api';
import type {
  BusinessValue,
  ProcessStep,
  Statistic,
  TeamMember,
  Technology,
} from './shared';

export interface AboutSectionHeadings {
  title: string;
  subtitle?: string | null;
  description?: string | null;
  button_label?: string | null;
  button_href?: string | null;
}

export interface AboutData {
  hero: { title: string; description: string };
  story: { title: string; content: string };
  mission: { title: string; content: string };
  vision: { title: string; content: string };
  values: BusinessValue[];
  values_section?: AboutSectionHeadings;
  team: TeamMember[];
  team_section?: AboutSectionHeadings;
  statistics: Statistic[];
  process_steps: ProcessStep[];
  process_section?: AboutSectionHeadings;
  technologies: Technology[];
  seo: SeoData | null;
}

export interface ContactFormData {
  services: { id: number; title: string; slug: string }[];
}

export interface ContactPayload {
  name: string;
  email: string;
  phone?: string;
  company?: string;
  service_id?: number;
  message: string;
}

export interface LegalPage {
  title: string;
  content: string;
  seo: SeoData | null;
}

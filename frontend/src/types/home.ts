import type { SeoData } from './api';

export interface HeroData {
  kicker: string;
  headline: {
    line1_prefix: string;
    line1_accent: string;
    line2: string;
  };
  description: string;
  primary_cta: { label: string; href: string };
  secondary_cta: { label: string; href: string };
  float_grow: { title: string; subtitle: string };
  float_idea: { title: string; subtitle: string };
  script: { line1: string; line2: string };
}

export interface SectionMeta {
  title: string;
  subtitle?: string | null;
  description?: string | null;
}

export interface SectionImage {
  url: string;
  alt: string;
}

export interface FocusArea {
  title: string;
  description: string;
}

export interface ClientLogo {
  id: number;
  name: string;
  logo?: { url: string; alt?: string } | null;
}

export interface HomeUiLabels {
  view_all: string;
  explore: string;
  projects_count: string;
  services: string;
}

export interface AboutSectionData extends SectionMeta {
  years_count?: string | null;
  progress_value?: number | null;
  progress_text?: string | null;
  solution_text?: string | null;
  button_label?: string | null;
  button_href?: string | null;
  image?: SectionImage | null;
  image_two?: SectionImage | null;
  since_year?: string | null;
  since_label?: string | null;
  award_winning?: string | null;
  experience_label?: string | null;
  challenge_label?: string | null;
}

export interface VideoSectionData {
  title: string;
  subtitle?: string | null;
  video_url?: string | null;
  image?: SectionImage | null;
}

export interface WordmarkSectionData {
  word: string;
  image?: SectionImage | null;
}

export interface HomeData {
  hero: HeroData;
  ui: HomeUiLabels;
  sections: {
    clients: SectionMeta & {
      badge_text?: string | null;
      image?: SectionImage | null;
      items: FocusArea[];
      logos: ClientLogo[];
    };
    services: SectionMeta;
    projects: SectionMeta;
    business_values: SectionMeta;
    process: SectionMeta & {
      button_label?: string | null;
      button_href?: string | null;
    };
    technology: SectionMeta;
    statistics: SectionMeta;
  testimonials: SectionMeta;
  cta: SectionMeta & {
      eyebrow?: string | null;
      button_label: string;
      button_href: string;
    };
    about: AboutSectionData;
    team: SectionMeta;
    awards: SectionMeta;
    video: VideoSectionData;
    wordmark: WordmarkSectionData;
    marquee: { items: string[] };
  };
  services: import('./service').Service[];
  projects: import('./project').Project[];
  business_values: import('./shared').BusinessValue[];
  process_steps: import('./shared').ProcessStep[];
  technologies: import('./shared').Technology[];
  statistics: import('./shared').Statistic[];
  testimonials: import('./shared').Testimonial[];
  awards: import('./shared').Award[];
  team_members: import('./shared').TeamMember[];
  seo: SeoData | null;
}

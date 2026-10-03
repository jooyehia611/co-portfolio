import {
  Blocks,
  Cloud,
  Code,
  Cpu,
  Database,
  Gauge,
  Globe,
  Handshake,
  Layers,
  Lightbulb,
  LineChart,
  Lock,
  Megaphone,
  MonitorSmartphone,
  Palette,
  Rocket,
  Settings,
  ShieldCheck,
  ShoppingCart,
  Smartphone,
  Sparkles,
  Target,
  Wrench,
  type LucideIcon,
} from 'lucide-react';

/* CMS icon slugs, plus the loose keywords editors tend to type. */
const iconMap: Record<string, LucideIcon> = {
  web: Globe,
  website: Globe,
  globe: Globe,
  code: Code,
  development: Code,
  mobile: Smartphone,
  smartphone: Smartphone,
  app: MonitorSmartphone,
  apps: MonitorSmartphone,
  ecommerce: ShoppingCart,
  'e-commerce': ShoppingCart,
  cart: ShoppingCart,
  design: Palette,
  palette: Palette,
  ui: Palette,
  'ui-ux': Palette,
  uiux: Palette,
  cloud: Cloud,
  devops: Cloud,
  consulting: Lightbulb,
  lightbulb: Lightbulb,
  strategy: Target,
  target: Target,
  marketing: Megaphone,
  branding: Sparkles,
  security: ShieldCheck,
  lock: Lock,
  database: Database,
  data: Database,
  analytics: LineChart,
  chart: LineChart,
  performance: Gauge,
  systems: Layers,
  layers: Layers,
  integration: Blocks,
  api: Blocks,
  automation: Settings,
  settings: Settings,
  support: Wrench,
  maintenance: Wrench,
  startup: Rocket,
  rocket: Rocket,
  partnership: Handshake,
  ai: Cpu,
};

/* Cycles a stable fallback set so cards never repeat side by side. */
const fallbacks: LucideIcon[] = [Code, Smartphone, ShoppingCart, Palette, Cloud, Lightbulb];

export function serviceIcon(icon?: string | null, index = 0): LucideIcon {
  if (icon) {
    const key = icon.toLowerCase().trim();
    if (iconMap[key]) return iconMap[key];

    const partial = Object.keys(iconMap).find((k) => key.includes(k));
    if (partial) return iconMap[partial];
  }

  return fallbacks[index % fallbacks.length];
}

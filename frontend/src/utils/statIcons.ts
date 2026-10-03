import {
  Award,
  Calendar,
  Folder,
  TrendingUp,
  UserRound,
  Users,
  Zap,
  type LucideIcon,
} from 'lucide-react';

const iconMap: Record<string, LucideIcon> = {
  folder: Folder,
  users: Users,
  calendar: Calendar,
  'user-group': Users,
  award: Award,
  zap: Zap,
  trending: TrendingUp,
  user: UserRound,
};

export function getStatIcon(icon?: string | null): LucideIcon {
  if (!icon) return TrendingUp;
  return iconMap[icon] ?? TrendingUp;
}

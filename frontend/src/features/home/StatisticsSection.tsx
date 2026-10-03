import { Boxes, CalendarDays, UserRound, Users } from 'lucide-react';
import { CountUp } from '@/components/ui/CountUp';
import { useI18n } from '@/i18n';
import type { Statistic } from '@/types/shared';

interface StatisticsSectionProps {
  statistics: Statistic[];
}

const icons = [Boxes, Users, CalendarDays, UserRound];
const hints = ['hero.statHintProjects', 'hero.statHintClients', 'hero.statHintYears', 'hero.statHintTeam'] as const;

export function StatisticsSection({ statistics }: StatisticsSectionProps) {
  const { t, dir } = useI18n();
  if (statistics.length === 0) return null;

  return (
    <section className="kpi-band">
      <div className="container-site">
        <div className="kpi-dock">
          {statistics.slice(0, 4).map((stat, index) => {
            const Icon = icons[index % icons.length];
            return (
              <article className="kpi-dock__item" key={stat.id} style={{ animationDelay: `${0.08 * index}s` }}>
                <span className="kpi-dock__icon" aria-hidden>
                  <Icon size={28} strokeWidth={1.7} />
                </span>
                <div className="kpi-dock__copy" dir={dir}>
                  <h2 className="kpi-dock__value">
                    <CountUp value={stat.value} suffix={stat.suffix ?? ''} />
                  </h2>
                  <p className="kpi-dock__label">{stat.label}</p>
                  <p className="kpi-dock__hint">{t(hints[index] ?? hints[0])}</p>
                </div>
              </article>
            );
          })}
        </div>
      </div>
    </section>
  );
}

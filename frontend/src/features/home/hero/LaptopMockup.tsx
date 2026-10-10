import {
  Bell,
  BarChart3,
  FolderKanban,
  LayoutDashboard,
  MessageSquare,
  Search,
  Settings,
  Users,
  Wifi,
} from 'lucide-react';

const BRAND = 'YTECH';
const LOGO_SRC = '/logo-icon.png';

const NAV = [
  { icon: LayoutDashboard, label: 'Overview', active: true },
  { icon: FolderKanban, label: 'Projects' },
  { icon: Users, label: 'Clients' },
  { icon: BarChart3, label: 'Analytics' },
  { icon: MessageSquare, label: 'Messages' },
  { icon: Settings, label: 'Settings' },
];

const STATS = [
  { label: 'Revenue', value: '$48,250', delta: '+12.4%' },
  { label: 'Active projects', value: '24', delta: '+8.1%' },
  { label: 'Happy clients', value: '45', delta: '+4.2%' },
];

const PROJECTS = [
  { name: 'E-commerce app', progress: 86 },
  { name: 'CRM platform', progress: 64 },
  { name: 'Brand website', progress: 92 },
  { name: 'Mobile app', progress: 48 },
  { name: 'Cloud migration', progress: 73 },
];

const CHART_LINE =
  'M0 62 C 14 58, 22 44, 36 47 S 58 60, 74 42 S 98 20, 114 30 S 138 44, 152 22 S 176 8, 192 14 S 214 24, 228 6';
const CHART_AREA = `${CHART_LINE} L228 80 L0 80 Z`;
const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];

const ACTIVITY = [
  { title: 'New order', meta: '2 min ago' },
  { title: 'Project updated', meta: '1 hr ago' },
  { title: 'New client', meta: '3 hr ago' },
];

function BrandMark({ className }: { className?: string }) {
  return (
    <span className={`dv-brand ${className ?? ''}`}>
      <img src={LOGO_SRC} alt="" className="dv-brand__logo" draggable={false} />
      <span className="dv-brand__name">{BRAND}</span>
    </span>
  );
}

export function LaptopMockup() {
  return (
    <div
      className="hero-devices"
      role="img"
      aria-label="YTECH dashboard shown on a laptop and a phone"
    >
      {/* ------------------------------ Laptop ------------------------------ */}
      <div className="dv-laptop" aria-hidden>
        <div className="dv-laptop__lid">
          <span className="dv-laptop__cam" />
          <div className="dv-screen">
            <aside className="dv-side">
              <BrandMark />
              <ul className="dv-side__nav">
                {NAV.map(({ icon: Icon, label, active }) => (
                  <li key={label} className={active ? 'is-active' : undefined}>
                    <Icon strokeWidth={2} />
                    {label}
                  </li>
                ))}
              </ul>
              <div className="dv-side__pro">
                <strong>Pro plan</strong>
                <span>All features unlocked</span>
              </div>
            </aside>

            <div className="dv-main">
              <header className="dv-top">
                <div>
                  <h4>Welcome back</h4>
                  <p>Here’s what’s happening with your business today.</p>
                </div>
                <div className="dv-top__tools">
                  <span className="dv-search">
                    <Search strokeWidth={2.2} />
                    Search
                  </span>
                  <span className="dv-bell">
                    <Bell strokeWidth={2.2} />
                  </span>
                  <span className="dv-avatar">Y</span>
                </div>
              </header>

              <div className="dv-stats">
                {STATS.map((s) => (
                  <div key={s.label} className="dv-card">
                    <small>{s.label}</small>
                    <b>{s.value}</b>
                    <em>{s.delta}</em>
                  </div>
                ))}
              </div>

              <div className="dv-grid">
                <div className="dv-card dv-chart">
                  <div className="dv-card__head">
                    <strong>Revenue overview</strong>
                    <span>Last 7 months</span>
                  </div>
                  <svg viewBox="0 0 228 80" preserveAspectRatio="none">
                    <defs>
                      <linearGradient id="dvArea" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0" stopColor="#0ea5e9" stopOpacity="0.38" />
                        <stop offset="1" stopColor="#0ea5e9" stopOpacity="0" />
                      </linearGradient>
                    </defs>
                    {[16, 36, 56].map((y) => (
                      <line key={y} x1="0" x2="228" y1={y} y2={y} className="dv-chart__grid" />
                    ))}
                    <path d={CHART_AREA} fill="url(#dvArea)" />
                    <path d={CHART_LINE} className="dv-chart__line" />
                    <circle cx="152" cy="22" r="3.2" className="dv-chart__dot" />
                  </svg>
                  <div className="dv-chart__months">
                    {MONTHS.map((m) => (
                      <span key={m}>{m}</span>
                    ))}
                  </div>
                </div>

                <div className="dv-card dv-projects">
                  <div className="dv-card__head">
                    <strong>Top projects</strong>
                  </div>
                  {PROJECTS.map((p) => (
                    <div key={p.name} className="dv-project">
                      <div>
                        <span>{p.name}</span>
                        <b>{p.progress}%</b>
                      </div>
                      <i>
                        <u style={{ width: `${p.progress}%` }} />
                      </i>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="dv-laptop__base">
          <span className="dv-laptop__notch" />
        </div>
      </div>

      {/* ------------------------------ iPhone ------------------------------ */}
      <div className="dv-phone" aria-hidden>
        <span className="dv-phone__btn dv-phone__btn--action" />
        <span className="dv-phone__btn dv-phone__btn--up" />
        <span className="dv-phone__btn dv-phone__btn--down" />
        <span className="dv-phone__btn dv-phone__btn--power" />
        <div className="dv-phone__screen">
          <span className="dv-phone__island" />
          <div className="dv-status">
            <b>9:41</b>
            <span>
              <Wifi strokeWidth={2.6} />
              <i className="dv-status__batt" />
            </span>
          </div>

          <div className="dv-app">
            <header className="dv-app__top">
              <BrandMark />
              <span className="dv-bell">
                <Bell strokeWidth={2.2} />
              </span>
            </header>

            <div className="dv-balance">
              <small>Total revenue</small>
              <b>$12,480</b>
              <em>+12.4% this month</em>
              <svg viewBox="0 0 120 34" preserveAspectRatio="none">
                <path
                  d="M0 28 C 10 26, 16 18, 26 20 S 44 28, 56 18 S 76 6, 88 12 S 106 16, 120 4"
                  className="dv-balance__line"
                />
              </svg>
            </div>

            <div className="dv-quick">
              {[FolderKanban, Users, BarChart3, MessageSquare].map((Icon, i) => (
                <span key={i}>
                  <Icon strokeWidth={2} />
                </span>
              ))}
            </div>

            <div className="dv-activity">
              <strong>Recent activity</strong>
              {ACTIVITY.map((a) => (
                <div key={a.title} className="dv-activity__row">
                  <span className="dv-activity__dot" />
                  <div>
                    <b>{a.title}</b>
                    <small>{a.meta}</small>
                  </div>
                </div>
              ))}
            </div>
          </div>

          <span className="dv-phone__home" />
        </div>
      </div>
    </div>
  );
}

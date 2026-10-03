import { useEffect, useState } from 'react';
import { gsap, ScrollSmoother, ScrollTrigger } from '@/lib/gsap';
import { useI18n } from '@/i18n';
import { cn } from '@/utils/cn';

export function ScrollToTop() {
  const { t } = useI18n();
  const [visible, setVisible] = useState(false);
  const [progress, setProgress] = useState(0);

  useEffect(() => {
    const update = () => {
      const smoother = ScrollSmoother.get();
      const wrapper = document.getElementById('smooth-wrapper');
      const y = smoother?.scrollTop() || wrapper?.scrollTop || window.scrollY;
      const max = wrapper
        ? Math.max(wrapper.scrollHeight - wrapper.clientHeight, 1)
        : Math.max(ScrollTrigger.maxScroll(window), 1);
      setVisible(y > 400);
      setProgress(Math.min(1, y / max));
    };

    update();
    gsap.ticker.add(update);
    window.addEventListener('scroll', update, { passive: true });

    return () => {
      gsap.ticker.remove(update);
      window.removeEventListener('scroll', update);
    };
  }, []);

  const toTop = () => {
    const smoother = ScrollSmoother.get();
    if (smoother) smoother.scrollTo(0, true);
    else window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <button
      type="button"
      className={cn('scroll-to-top', visible && 'is-visible')}
      onClick={toTop}
      aria-label={t('common.backTop')}
    >
      <span className="scroll-to-top__text">{t('common.backTop')}</span>
      <span className="scroll-to-top__wrapper">
        <span className="scroll-to-top__inner" style={{ width: `${(1 - progress) * 100}%` }} />
      </span>
    </button>
  );
}

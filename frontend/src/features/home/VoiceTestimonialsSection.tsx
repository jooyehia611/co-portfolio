import { useRef, useState } from 'react';
import { Pause, Play, AudioLines, ArrowUpRight, ArrowLeft, ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';
import { Swiper, SwiperSlide } from 'swiper/react';
import type { Swiper as SwiperClass } from 'swiper';
import { SectionTitle } from '@/components/ui/SectionTitle';
import { useI18n } from '@/i18n';
import type { Testimonial } from '@/types/shared';

const BAR_COUNT = 33;

function formatTime(value: number): string {
  const seconds = Number.isFinite(value) ? Math.floor(value) : 0;
  return `${Math.floor(seconds / 60)}:${String(seconds % 60).padStart(2, '0')}`;
}

function VoiceCard({ item, index, total, activeId, setActiveId, locale }: {
  item: Testimonial;
  index: number;
  total: number;
  activeId: number | null;
  setActiveId: (value: number | null) => void;
  locale: 'ar' | 'en';
}) {
  const audioRef = useRef<HTMLAudioElement>(null);
  const [currentTime, setCurrentTime] = useState(0);
  const [duration, setDuration] = useState(item.audio_duration || 0);
  const playing = activeId === item.id;
  const progress = duration > 0 ? Math.min(currentTime / duration, 1) : 0;
  const currentBar = Math.floor(progress * BAR_COUNT);

  function togglePlayback() {
    const audio = audioRef.current;
    if (!audio) return;
    if (playing) {
      audio.pause();
      return;
    }
    document.querySelectorAll<HTMLAudioElement>('.voice-card audio').forEach((other) => {
      if (other !== audio) other.pause();
    });
    void audio.play().catch(() => setActiveId(null));
  }

  return <article className={`voice-card${playing ? ' voice-card--playing' : ''}`}>
    <div className="voice-card__top">
      <span className="voice-card__sound-icon" aria-hidden="true"><AudioLines size={22} /></span>
      <span>{String(index + 1).padStart(2, '0')} / {String(total).padStart(2, '0')}</span>
    </div>

    <div className="voice-card__wave" aria-hidden="true" dir="ltr">
      {Array.from({ length: BAR_COUNT }, (_, i) => <span
        key={i}
        className={`${i < currentBar ? 'is-played' : ''} ${i === currentBar && playing ? 'is-current' : ''}`}
        style={{ height: `${12 + ((i * 17 + index * 11) % 33)}px`, animationDelay: `${(i % 7) * -0.13}s`, animationDuration: `${0.7 + (i % 5) * 0.16}s` }}
      />)}
    </div>
    <div className="voice-card__timeline" dir="ltr">
      <time>{formatTime(currentTime)}</time>
      <div className="voice-card__track" role="progressbar" aria-label={locale === 'ar' ? 'تقدم التسجيل' : 'Recording progress'} aria-valuenow={Math.round(progress * 100)} aria-valuemin={0} aria-valuemax={100}>
        <span style={{ width: `${progress * 100}%` }} />
      </div>
      <time>{formatTime(duration)}</time>
    </div>

    {item.review && <p className="voice-card__quote">“{item.review}”</p>}
    <div className="voice-card__bottom">
      <div className="voice-card__person">
        <span className="voice-card__avatar">{item.client_name.slice(0, 1)}</span>
        <div><strong>{item.client_name}</strong><small>{[item.position, item.company].filter(Boolean).join(' · ') || (locale === 'ar' ? 'عميلنا' : 'Our client')}</small></div>
      </div>
      <button type="button" className="voice-card__play" aria-label={`${playing ? (locale === 'ar' ? 'إيقاف' : 'Pause') : (locale === 'ar' ? 'تشغيل' : 'Play')} ${item.client_name}`} aria-pressed={playing} onClick={togglePlayback}>
        {playing ? <Pause size={19} fill="currentColor" /> : <Play size={19} fill="currentColor" />}
      </button>
    </div>
    <audio
      ref={audioRef}
      src={item.audio_url!}
      preload="metadata"
      onLoadedMetadata={(event) => setDuration(event.currentTarget.duration || item.audio_duration || 0)}
      onDurationChange={(event) => { if (Number.isFinite(event.currentTarget.duration)) setDuration(event.currentTarget.duration); }}
      onTimeUpdate={(event) => setCurrentTime(event.currentTarget.currentTime)}
      onPlay={() => setActiveId(item.id)}
      onPause={() => { if (activeId === item.id) setActiveId(null); }}
      onEnded={() => { setCurrentTime(0); setActiveId(null); }}
    />
  </article>;
}

export function VoiceTestimonialsGrid({ testimonials }: { testimonials: Testimonial[] }) {
  const { locale } = useI18n();
  const [activeId, setActiveId] = useState<number | null>(null);
  const voices = testimonials.filter((item) => item.audio_url);

  return <div className="voice-testimonials__grid">
    {voices.map((item, index) => <VoiceCard key={item.id} item={item} index={index} total={voices.length} activeId={activeId} setActiveId={setActiveId} locale={locale} />)}
  </div>;
}

export function VoiceTestimonialsSection({ title, tagline, text, testimonials }: {
  title: string;
  tagline?: string | null;
  text?: string | null;
  testimonials: Testimonial[];
}) {
  const { locale, dir, t, localizedPath } = useI18n();
  const swiperRef = useRef<SwiperClass | null>(null);
  const [activeId, setActiveId] = useState<number | null>(null);
  const [slideIndex, setSlideIndex] = useState(0);
  const [sliderProgress, setSliderProgress] = useState(0);
  const [canPrev, setCanPrev] = useState(false);
  const [canNext, setCanNext] = useState(false);
  const voices = testimonials.filter((item) => item.audio_url);
  if (!voices.length) return null;

  function syncSlider(swiper: SwiperClass) {
    setSlideIndex(swiper.activeIndex);
    const visibleSlides = typeof swiper.params.slidesPerView === 'number' ? swiper.params.slidesPerView : 1;
    setSliderProgress(Math.min(1, (swiper.activeIndex + visibleSlides) / voices.length));
    setCanPrev(!swiper.isBeginning);
    setCanNext(!swiper.isEnd);
  }

  function pauseReviews() {
    document.querySelectorAll<HTMLAudioElement>('.voice-testimonials--home .voice-card audio').forEach((audio) => audio.pause());
    setActiveId(null);
  }

  return <section className="voice-testimonials voice-testimonials--home section-space" aria-label={title}>
    <div className="container-site">
      <div className="voice-testimonials__header">
        <SectionTitle tagline={tagline || (locale === 'ar' ? 'أصوات عملائنا' : 'CLIENT VOICES')} title={title} text={text} />
        <div className="voice-testimonials__header-mark" aria-hidden="true"><AudioLines size={46} strokeWidth={1.4} /></div>
      </div>
      <Swiper
        className={`voice-testimonials__slider${voices.length === 1 ? ' voice-testimonials__slider--single' : voices.length === 2 ? ' voice-testimonials__slider--pair' : ''}`}
        key={dir}
        dir={dir}
        slidesPerView={voices.length > 1 ? 1.08 : 1}
        spaceBetween={16}
        speed={600}
        watchOverflow
        breakpoints={{
          640: { slidesPerView: voices.length > 1 ? 1.4 : 1, spaceBetween: 20 },
          768: { slidesPerView: Math.min(2, voices.length), spaceBetween: 20 },
          1100: { slidesPerView: Math.min(3, voices.length), spaceBetween: 24 },
        }}
        onSwiper={(swiper) => { swiperRef.current = swiper; syncSlider(swiper); }}
        onSlideChange={(swiper) => { pauseReviews(); syncSlider(swiper); }}
        onResize={syncSlider}
      >
        {voices.map((item, index) => <SwiperSlide key={item.id}>
          <VoiceCard item={item} index={index} total={voices.length} activeId={activeId} setActiveId={setActiveId} locale={locale} />
        </SwiperSlide>)}
      </Swiper>
      {voices.length > 1 && <div className="voice-testimonials__controls">
        <div className="voice-testimonials__slide-status" aria-live="polite">
          <span>{String(slideIndex + 1).padStart(2, '0')} <span aria-hidden="true">/</span> {String(voices.length).padStart(2, '0')}</span>
          <div className="voice-testimonials__slide-track" aria-hidden="true"><span style={{ width: `${sliderProgress * 100}%` }} /></div>
        </div>
        <div className="voice-testimonials__navigation">
          <button type="button" onClick={() => swiperRef.current?.slidePrev()} disabled={!canPrev} aria-label={t('common.prev')}>
            {dir === 'rtl' ? <ArrowRight size={20} /> : <ArrowLeft size={20} />}
          </button>
          <button type="button" onClick={() => swiperRef.current?.slideNext()} disabled={!canNext} aria-label={t('common.next')}>
            {dir === 'rtl' ? <ArrowLeft size={20} /> : <ArrowRight size={20} />}
          </button>
        </div>
      </div>}
      <div className="voice-testimonials__footer">
        <Link to={localizedPath('/reviews')} className="voice-testimonials__all">
          {t('reviews.viewAll')} <ArrowUpRight size={19} aria-hidden="true" />
        </Link>
      </div>
    </div>
  </section>;
}

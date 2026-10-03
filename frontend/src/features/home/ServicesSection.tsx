import { useRef } from 'react';
import { Link } from 'react-router-dom';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Navigation } from 'swiper/modules';
import type { Swiper as SwiperClass } from 'swiper';
import { ArrowLeft, ArrowRight, ArrowUpRight } from 'lucide-react';
import { useI18n } from '@/i18n';
import { SectionTitle } from '@/components/ui/SectionTitle';
import { ServiceCard } from '@/features/home/ServiceCard';
import type { Service } from '@/types/service';

interface ServicesSectionProps {
  tagline?: string | null;
  title: string;
  text?: string | null;
  services: Service[];
}

export function ServicesSection({ tagline, title, text, services }: ServicesSectionProps) {
  const { t, dir, localizedPath } = useI18n();
  const swiperRef = useRef<SwiperClass | null>(null);

  if (services.length === 0) return null;

  return (
    <section className="services-one section-space">
      <div className="container-site">
        <div className="services-one__top">
          <SectionTitle tagline={tagline || t('hero.ourServices')} title={title} text={text} />

          <div className="custom-nav">
            <button
              type="button"
              className="custom-nav__btn"
              onClick={() => swiperRef.current?.slidePrev()}
              aria-label={t('common.prev')}
            >
              <ArrowLeft size={20} />
            </button>
            <button
              type="button"
              className="custom-nav__btn"
              onClick={() => swiperRef.current?.slideNext()}
              aria-label={t('common.next')}
            >
              <ArrowRight size={20} />
            </button>
          </div>
        </div>

        <Swiper
          className="services-one__carousel"
          modules={[Navigation, Autoplay]}
          onSwiper={(s) => {
            swiperRef.current = s;
          }}
          key={dir}
          dir={dir}
          spaceBetween={0}
          slidesPerView={1}
          loop={services.length > 4}
          speed={700}
          autoplay={{ delay: 4500, disableOnInteraction: true }}
          breakpoints={{
            768: { slidesPerView: 2 },
            992: { slidesPerView: 3 },
            1200: { slidesPerView: 4 },
          }}
        >
          {services.map((service, index) => (
            <SwiperSlide key={service.id}>
              <ServiceCard service={service} index={index} />
            </SwiperSlide>
          ))}
        </Swiper>

        <div className="voice-testimonials__footer">
          <Link to={localizedPath('/services')} className="voice-testimonials__all">
            {t('services.viewAll')} <ArrowUpRight size={19} aria-hidden="true" />
          </Link>
        </div>
      </div>
    </section>
  );
}

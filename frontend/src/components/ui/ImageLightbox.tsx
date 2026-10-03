import { useEffect } from 'react';
import { createPortal } from 'react-dom';
import { X } from 'lucide-react';
import { useI18n } from '@/i18n';

interface ImageLightboxProps {
  src: string;
  alt: string;
  caption?: string | null;
  onClose: () => void;
}

export function ImageLightbox({ src, alt, caption, onClose }: ImageLightboxProps) {
  const { t } = useI18n();

  useEffect(() => {
    const onKey = (e: KeyboardEvent) => {
      if (e.key === 'Escape') onClose();
    };
    window.addEventListener('keydown', onKey);
    const prevOverflow = document.body.style.overflow;
    document.body.style.overflow = 'hidden';
    return () => {
      window.removeEventListener('keydown', onKey);
      document.body.style.overflow = prevOverflow;
    };
  }, [onClose]);

  return createPortal(
    <div
      className="image-lightbox"
      onClick={onClose}
      role="dialog"
      aria-modal="true"
      aria-label={alt}
    >
      <button
        type="button"
        className="image-lightbox__close"
        onClick={onClose}
        aria-label={t('nav.close')}
      >
        <X size={18} />
      </button>

      <figure className="image-lightbox__panel" onClick={(e) => e.stopPropagation()}>
        <img
          className="image-lightbox__img"
          src={src}
          alt={alt}
          decoding="async"
        />
        {caption && <figcaption className="image-lightbox__caption">{caption}</figcaption>}
      </figure>
    </div>,
    document.body,
  );
}

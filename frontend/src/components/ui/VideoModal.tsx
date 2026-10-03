import { useEffect } from 'react';
import { X } from 'lucide-react';
import { useI18n } from '@/i18n';

interface VideoModalProps {
  url: string;
  onClose: () => void;
}

/* Turns a watch/share URL into something that can live in an iframe. */
function toEmbedUrl(url: string): string | null {
  try {
    const parsed = new URL(url);
    const host = parsed.hostname.replace(/^www\./, '');

    if (host === 'youtu.be') {
      return `https://www.youtube.com/embed${parsed.pathname}?autoplay=1`;
    }
    if (host.endsWith('youtube.com')) {
      const id = parsed.searchParams.get('v');
      if (id) return `https://www.youtube.com/embed/${id}?autoplay=1`;
      if (parsed.pathname.startsWith('/embed/')) return `${url}${parsed.search ? '&' : '?'}autoplay=1`;
    }
    if (host.endsWith('vimeo.com')) {
      const id = parsed.pathname.split('/').filter(Boolean)[0];
      if (id) return `https://player.vimeo.com/video/${id}?autoplay=1`;
    }
    return null;
  } catch {
    return null;
  }
}

export function VideoModal({ url, onClose }: VideoModalProps) {
  const { t } = useI18n();
  const embed = toEmbedUrl(url);

  useEffect(() => {
    const onKey = (e: KeyboardEvent) => {
      if (e.key === 'Escape') onClose();
    };
    window.addEventListener('keydown', onKey);
    document.body.style.overflow = 'hidden';
    return () => {
      window.removeEventListener('keydown', onKey);
      document.body.style.overflow = '';
    };
  }, [onClose]);

  return (
    <div className="video-modal" onClick={onClose} role="dialog" aria-modal="true">
      <div className="video-modal__frame" onClick={(e) => e.stopPropagation()}>
        <button
          type="button"
          className="video-modal__close"
          onClick={onClose}
          aria-label={t('common.closeVideo')}
        >
          <X size={18} />
        </button>

        {embed ? (
          <iframe
            src={embed}
            title={t('home.watchVideo')}
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; picture-in-picture"
            allowFullScreen
          />
        ) : (
          /* Self-hosted file rather than a streaming platform. */
          <video src={url} controls autoPlay playsInline />
        )}
      </div>
    </div>
  );
}

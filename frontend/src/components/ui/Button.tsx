import { forwardRef, type ButtonHTMLAttributes, type ReactNode } from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight } from 'lucide-react';
import { cn } from '@/utils/cn';

type ButtonVariant = 'primary' | 'light' | 'outline';

interface ButtonProps extends Omit<ButtonHTMLAttributes<HTMLButtonElement>, 'color'> {
  variant?: ButtonVariant;
  href?: string;
  external?: boolean;
  /* Hides the detached circular icon, leaving only the pill. */
  bare?: boolean;
  icon?: ReactNode;
  children?: ReactNode;
}

const variantClass: Record<ButtonVariant, string> = {
  primary: '',
  light: 'yt-btn--light',
  outline: 'yt-btn--outline',
};

/*
  The pill label and the circular icon are separate elements: hovering
  drives skewed panels across the label while the circle inverts.
*/
export const Button = forwardRef<HTMLButtonElement, ButtonProps>(
  (
    {
      className,
      variant = 'primary',
      href,
      external,
      bare = false,
      icon,
      children,
      disabled,
      type = 'button',
      ...rest
    },
    ref,
  ) => {
    const classes = cn('yt-btn', variantClass[variant], disabled && 'pointer-events-none opacity-50', className);

    const inner = (
      <>
        <span className="yt-btn__text">{children}</span>
        {!bare && (
          <span className="yt-btn__icon-box">
            <span className="yt-btn__icon">{icon ?? <ArrowRight size={16} strokeWidth={2.5} />}</span>
          </span>
        )}
      </>
    );

    if (href) {
      if (external || href.startsWith('http') || href.startsWith('mailto:') || href.startsWith('tel:')) {
        return (
          <a
            href={href}
            className={classes}
            target={external ? '_blank' : undefined}
            rel={external ? 'noopener noreferrer' : undefined}
          >
            {inner}
          </a>
        );
      }

      return (
        <Link to={href} className={classes}>
          {inner}
        </Link>
      );
    }

    return (
      <button ref={ref} type={type} className={classes} disabled={disabled} {...rest}>
        {inner}
      </button>
    );
  },
);

Button.displayName = 'Button';

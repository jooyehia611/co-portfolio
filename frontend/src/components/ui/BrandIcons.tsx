/*
  Lucide v1 removed brand glyphs, so the social marks live here as
  minimal inline paths sized to the 24px grid.
*/
interface IconProps {
  size?: number;
  className?: string;
}

function svgProps(size: number) {
  return {
    width: size,
    height: size,
    viewBox: '0 0 24 24',
    fill: 'currentColor',
    'aria-hidden': true as const,
  };
}

export function FacebookIcon({ size = 16, className }: IconProps) {
  return (
    <svg {...svgProps(size)} className={className}>
      <path d="M14.5 8.5V6.8c0-.8.2-1.2 1.3-1.2h1.6V2.7c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v1.6H8.1v3.2h2.6V21h3.8v-9.3h2.6l.4-3.2h-3z" />
    </svg>
  );
}

export function XIcon({ size = 16, className }: IconProps) {
  return (
    <svg {...svgProps(size)} className={className}>
      <path d="M17.5 3h3.2l-7 8 7.8 10h-6l-4.7-6.1L5.4 21H2.2l7.4-8.4L2.1 3h6.1l4.4 5.8L17.5 3zm-1.1 16h1.8L7.5 4.8H5.6l10.8 14.2z" />
    </svg>
  );
}

export function LinkedinIcon({ size = 16, className }: IconProps) {
  return (
    <svg {...svgProps(size)} className={className}>
      <path d="M6.5 21H3V9h3.5v12zM4.7 7.4A2 2 0 1 1 4.8 3.4a2 2 0 0 1-.1 4zM21 21h-3.5v-6.3c0-1.6-.6-2.5-1.9-2.5-1 0-1.6.7-1.9 1.4-.1.2-.1.6-.1 1V21H10s.1-10.8 0-12h3.5v1.7c.5-.8 1.3-1.9 3.3-1.9 2.4 0 4.2 1.6 4.2 5V21z" />
    </svg>
  );
}

export function InstagramIcon({ size = 16, className }: IconProps) {
  return (
    <svg {...svgProps(size)} className={className}>
      <path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.3 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .3-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.3-2.2-.4-.6-.2-1-.5-1.4-.9a3.7 3.7 0 0 1-.9-1.4c-.2-.4-.3-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.9c.1-1.2.3-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.3 2.2-.4C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.1 0-3.5 0-4.7.1-.9 0-1.4.2-1.7.3-.4.2-.7.4-1 .6-.2.3-.4.6-.6 1-.1.3-.3.8-.3 1.7-.1 1.2-.1 1.6-.1 4.7s0 3.5.1 4.7c0 .9.2 1.4.3 1.7.2.4.4.7.6 1 .3.2.6.4 1 .6.3.1.8.3 1.7.3 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c.9 0 1.4-.2 1.7-.3.4-.2.7-.4 1-.6.2-.3.4-.6.6-1 .1-.3.3-.8.3-1.7.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c0-.9-.2-1.4-.3-1.7a2.7 2.7 0 0 0-.6-1c-.3-.2-.6-.4-1-.6-.3-.1-.8-.3-1.7-.3-1.2-.1-1.6-.1-4.7-.1zm0 3.1a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 8.2a3.2 3.2 0 1 0 0-6.4 3.2 3.2 0 0 0 0 6.4zm6.4-8.4a1.2 1.2 0 1 1-2.4 0 1.2 1.2 0 0 1 2.4 0z" />
    </svg>
  );
}

export function GithubIcon({ size = 16, className }: IconProps) {
  return (
    <svg {...svgProps(size)} className={className}>
      <path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-1.8c-2.8.6-3.4-1.3-3.4-1.3-.4-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.3 1.1 2.9.8.1-.6.4-1.1.7-1.4-2.2-.2-4.6-1.1-4.6-5 0-1.1.4-2 1-2.7-.1-.3-.4-1.3.1-2.6 0 0 .8-.3 2.7 1a9.4 9.4 0 0 1 5 0c1.9-1.3 2.7-1 2.7-1 .5 1.3.2 2.3.1 2.6.6.7 1 1.6 1 2.7 0 3.9-2.4 4.8-4.6 5 .4.3.7 1 .7 2v2.9c0 .3.2.6.8.5A10 10 0 0 0 12 2z" />
    </svg>
  );
}

export function BehanceIcon({ size = 16, className }: IconProps) {
  return (
    <svg {...svgProps(size)} className={className}>
      <path d="M8.1 5.5c.7 0 1.4.1 2 .2.6.1 1.1.3 1.5.6.4.3.7.7.9 1.1.2.5.3 1.1.3 1.8 0 .8-.2 1.4-.5 2-.4.5-.9.9-1.6 1.2.9.3 1.6.7 2 1.4.5.7.7 1.5.7 2.4 0 .8-.1 1.4-.4 2-.3.6-.7 1-1.2 1.3-.5.4-1.1.6-1.8.8-.6.2-1.3.2-2 .2H2V5.5h6.1zm-.4 5.9c.6 0 1-.1 1.4-.4.4-.3.5-.7.5-1.3 0-.4 0-.7-.2-.9a1.2 1.2 0 0 0-.5-.5 1.9 1.9 0 0 0-.7-.2 5 5 0 0 0-.8-.1H4.9v3.4h2.8zm.2 6.2c.3 0 .6 0 .9-.1.3 0 .5-.2.7-.3.2-.2.4-.4.5-.6.1-.3.2-.6.2-1 0-.8-.2-1.3-.6-1.7-.5-.3-1.1-.5-1.8-.5H4.9v4.2h3zM17 17.6c.4.4 1 .6 1.7.6.5 0 1-.1 1.4-.4.4-.2.6-.5.7-.8h2.1c-.3 1.1-.9 1.8-1.6 2.3a4.8 4.8 0 0 1-2.7.7c-.7 0-1.4-.1-2-.4a4.3 4.3 0 0 1-2.5-2.6 5.6 5.6 0 0 1 0-3.9 4.5 4.5 0 0 1 4.5-3 4 4 0 0 1 2 .5c.6.3 1 .8 1.4 1.3.4.5.6 1.1.8 1.8.1.7.2 1.4.1 2.1h-6.8c0 .8.2 1.5.6 1.9zm3-5.2c-.3-.4-.8-.5-1.5-.5-.4 0-.8.1-1.1.2-.3.2-.5.4-.6.6l-.3.6c-.1.2-.1.4-.1.6h4.2c-.1-.7-.3-1.2-.6-1.5zM15.2 6.8h5.3v1.5h-5.3V6.8z" />
    </svg>
  );
}

export function DribbbleIcon({ size = 16, className }: IconProps) {
  return (
    <svg {...svgProps(size)} className={className}>
      <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm6.6 4.6a8.3 8.3 0 0 1 1.9 5.2c-.3-.1-3.2-.7-6.2-.3l-.3-.7c-.2-.4-.4-.8-.5-1.2 3.3-1.4 4.8-3.3 5.1-3zm-1.2-1.2c-.3.4-1.6 2.2-4.7 3.4a43 43 0 0 0-3.4-5.3 8.4 8.4 0 0 1 8.1 1.9zM7.4 4.2a50 50 0 0 1 3.4 5.2c-4 1.1-7.5 1-7.9 1a8.4 8.4 0 0 1 4.5-6.2zM2.8 12v-.3c.4 0 4.5.1 8.7-1.2l.7 1.4c-3.3 1-5.9 3.9-6.3 4.4A8.3 8.3 0 0 1 2.8 12zm4.4 5.6c.3-.5 2.3-3.1 6-4.4a26 26 0 0 1 1.4 5 8.4 8.4 0 0 1-7.4-.6zm9 0a34 34 0 0 0-1.3-4.8c2.8-.4 5.3.3 5.6.4a8.4 8.4 0 0 1-4.3 4.4z" />
    </svg>
  );
}

export const brandIcons = {
  facebook: FacebookIcon,
  twitter: XIcon,
  linkedin: LinkedinIcon,
  instagram: InstagramIcon,
  github: GithubIcon,
  behance: BehanceIcon,
  dribbble: DribbbleIcon,
} as const;

export type BrandKey = keyof typeof brandIcons;

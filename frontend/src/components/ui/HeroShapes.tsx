import type { SVGProps } from 'react';

type ShapeProps = SVGProps<SVGSVGElement>;

/* Four-point sparkle that sits beside the accent word. */
export function SparkleShape(props: ShapeProps) {
  return (
    <svg viewBox="0 0 68 79" fill="none" aria-hidden {...props}>
      <path
        d="M34 2.5c1.4 12.8 7.6 24.4 17.6 32.4C41.6 43 35.4 54.6 34 67.4 32.6 54.6 26.4 43 16.4 34.9 26.4 26.9 32.6 15.3 34 2.5Z"
        fill="currentColor"
      />
      <path
        d="M58 24.5c.7 6.6 4 12.6 9.1 16.7-5.1 4.1-8.4 10.1-9.1 16.7-.7-6.6-4-12.6-9.1-16.7 5.1-4.1 8.4-10.1 9.1-16.7Z"
        fill="currentColor"
        opacity="0.85"
      />
    </svg>
  );
}

/* Hollow orbit that leads the second headline line. */
export function OrbitShape(props: ShapeProps) {
  return (
    <svg viewBox="0 0 73 73" fill="none" aria-hidden {...props}>
      <circle cx="36.5" cy="36.5" r="33" stroke="currentColor" strokeWidth="2.4" />
      <circle cx="36.5" cy="36.5" r="11" fill="currentColor" />
    </svg>
  );
}

/* Dashed ring that spins beside the short left caption. */
export function RingShape(props: ShapeProps) {
  return (
    <svg viewBox="0 0 65 65" fill="none" aria-hidden {...props}>
      <circle
        cx="32.5"
        cy="32.5"
        r="28"
        stroke="currentColor"
        strokeWidth="2"
        strokeDasharray="8 7"
      />
      <circle cx="32.5" cy="4.8" r="3.2" fill="currentColor" />
    </svg>
  );
}

/* Large asterisk that slowly rotates on the hero's lower corner. */
export function AsteriskShape(props: ShapeProps) {
  return (
    <svg viewBox="0 0 149 154" fill="none" aria-hidden {...props}>
      <path
        d="M74.5 8v138M18 45.5l113 63M18 108.5l113-63"
        stroke="currentColor"
        strokeWidth="10"
        strokeLinecap="round"
      />
    </svg>
  );
}

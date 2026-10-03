import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';
import { SplitText } from 'gsap/SplitText';
import { CustomEase } from 'gsap/CustomEase';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother, SplitText, CustomEase);

/* Matches the easing curve used across the reference design. */
export const ytEase = CustomEase.create('ytEase', '0.25, 1, 0.5, 1');

/*
  ScrollTrigger only fires once the page scrolls past its start line, so
  anything already on screen at mount (hero, page banners, short pages)
  would sit in its "before" state forever. Those play straight away.
*/
export function isOnScreen(el: Element, ratio = 0.92): boolean {
  return el.getBoundingClientRect().top < window.innerHeight * ratio;
}

export function prefersReducedMotion(): boolean {
  return (
    typeof window !== 'undefined' &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches
  );
}

export { gsap, ScrollTrigger, ScrollSmoother, SplitText, CustomEase };

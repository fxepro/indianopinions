import type { NavItem } from './navigation';

export type FooterColumn = {
  title: string;
  links: NavItem[];
};

export const footerColumns: FooterColumn[] = [
  {
    title: 'IndianOpinions',
    links: [],
  },
];

export const footerLegalLinks: NavItem[] = [
  { label: 'Editorial Ethics', href: '/legal/ethics' },
  { label: 'Strategic Partners', href: '/legal/partners' },
  { label: 'Contact', href: '/contact' },
  { label: 'LinkedIn', href: 'https://linkedin.com' },
];

export type LegalLink = {
  label: string;
  href: string;
  summary: string;
};

/** Individual legal documents (excludes the hub index page). */
export const legalDocuments: LegalLink[] = [
  {
    label: 'Privacy Policy',
    href: '/legal/privacy',
    summary: 'How we collect, use, and protect personal information when you use our website.',
  },
  {
    label: 'Cookie Policy',
    href: '/legal/cookies',
    summary: 'How we use cookies and similar technologies, and how you can manage preferences.',
  },
  {
    label: 'Do Not Sell or Share My Personal Information',
    href: '/legal/do-not-sell',
    summary:
      'Your choices regarding the sale or sharing of personal information for advertising and analytics.',
  },
  {
    label: 'Copyright Policy',
    href: '/legal/copyright',
    summary: 'Ownership of editorial content, permitted use, and how to request republication or report infringement.',
  },
  {
    label: 'Terms of Use',
    href: '/legal/terms',
    summary: 'Terms and conditions governing access to and use of the Indian Opinions website.',
  },
  {
    label: 'Your Ad Choices',
    href: '/legal/ad-choices',
    summary: 'How to limit interest-based advertising and manage advertising-related data uses.',
  },
  {
    label: 'Accessibility',
    href: '/legal/accessibility',
    summary: 'Our commitment to accessible design and how to report barriers or request assistance.',
  },
];

/** Footer order aligned with major publisher practice (WSJ-style). */
export const footerLegalLinks: LegalLink[] = [
  legalDocuments[0],
  legalDocuments[1],
  legalDocuments[2],
  legalDocuments[3],
  {
    label: 'Legal Policies',
    href: '/legal',
    summary: 'Index of all legal, privacy, and compliance documents for Indian Opinions.',
  },
  legalDocuments[4],
  legalDocuments[5],
  legalDocuments[6],
];

const splitAt = Math.ceil(footerLegalLinks.length / 2);

/** Two-column footer layout — first half / second half. */
export const footerLegalColumns: [LegalLink[], LegalLink[]] = [
  footerLegalLinks.slice(0, splitAt),
  footerLegalLinks.slice(splitAt),
];

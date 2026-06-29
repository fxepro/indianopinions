import Link from 'next/link';
import type { LegalDocumentData } from '@/content/legal/types';
import { site } from '@/config/site';

export const accessibilityStatement: LegalDocumentData = {
  title: 'Accessibility',
  description: 'Our commitment to making Indian Opinions accessible to all readers.',
  lastUpdated: '26 June 2026',
  sections: [
    {
      title: 'Our Commitment',
      content: [
        <>
          {site.name} is committed to ensuring our website is accessible to the widest possible audience,
          including people with disabilities. We aim to conform to the Web Content Accessibility
          Guidelines (WCAG) 2.1 Level AA where practicable, and we continue to improve the reading
          experience as our site evolves.
        </>,
      ],
    },
    {
      title: 'Measures We Take',
      content: [
        <>We work to incorporate accessibility into our design and development process, including:</>,
        <ul key="measures">
          <li>Semantic HTML structure for articles, navigation, and page landmarks</li>
          <li>Sufficient colour contrast for body text and interactive elements</li>
          <li>Keyboard-accessible navigation and visible focus indicators</li>
          <li>Text alternatives for meaningful images where we control production</li>
          <li>Responsive layouts that support zoom and smaller viewports</li>
          <li>Clear heading hierarchy within long-form editorial content</li>
        </ul>,
        <>
          We review new features and templates for accessibility before release and remediate issues when
          they are identified.
        </>,
      ],
    },
    {
      title: 'Known Limitations',
      content: [
        <>
          Some third-party embeds, archived material, or legacy content may not fully meet our target
          standard. We prioritise fixes that affect core reading paths — homepage, article pages, section
          fronts, and account or subscription flows as they are introduced.
        </>,
        <>
          PDF downloads or externally hosted media linked from our pages are subject to the accessibility
          practices of those providers.
        </>,
      ],
    },
    {
      title: 'Assistive Technology',
      content: [
        <>
          Our site is tested with common browsers and assistive technologies, including screen readers and
          keyboard-only navigation. If you use a specific assistive technology and encounter a barrier,
          please tell us so we can investigate.
        </>,
      ],
    },
    {
      title: 'Feedback and Assistance',
      content: [
        <>
          If you have difficulty accessing any part of {site.url.replace('https://', '')}, or if you require
          content in an alternative format, contact us at{' '}
          <a href={`mailto:${site.privacyEmail}`}>{site.privacyEmail}</a>. Please include:
        </>,
        <ul key="feedback">
          <li>The page URL where you encountered the barrier</li>
          <li>A description of the problem</li>
          <li>Your browser, device, and assistive technology (if applicable)</li>
        </ul>,
        <>
          We aim to respond within five business days and will work with you to provide the information or
          functionality you need through an alternative channel where possible.
        </>,
      ],
    },
    {
      title: 'Related Policies',
      content: [
        <>
          For information about how we handle personal data, see our{' '}
          <Link href="/legal/privacy">Privacy Policy</Link>. For general site terms, see our{' '}
          <Link href="/legal/terms">Terms of Use</Link>.
        </>,
      ],
    },
  ],
};

import Link from 'next/link';
import type { LegalDocumentData } from '@/content/legal/types';
import { site } from '@/config/site';

export const adChoicesPolicy: LegalDocumentData = {
  title: 'Your Ad Choices',
  description: 'How to manage interest-based advertising and related data uses on Indian Opinions.',
  lastUpdated: '26 June 2026',
  sections: [
    {
      title: 'Overview',
      content: [
        <>
          {site.name} may display advertising on our website and in related digital products. Some
          advertising is interest-based — meaning it is selected using information about your visits to
          this Site and other sites over time. This page explains your choices.
        </>,
        <>
          For broader privacy practices, see our <Link href="/legal/privacy">Privacy Policy</Link>. For
          cookie details, see our <Link href="/legal/cookies">Cookie Policy</Link>.
        </>,
      ],
    },
    {
      title: 'How Interest-Based Advertising Works',
      content: [
        <>
          Advertising partners may use cookies, pixels, mobile identifiers, and similar technologies to
          collect information about your browser or device, pages viewed, and general location (usually at
          city or region level). They use this information to deliver ads that may be more relevant to you
          and to measure campaign performance.
        </>,
        <>
          We contractually require partners to handle data in accordance with applicable law and our
          instructions, but third-party ad networks have their own privacy policies.
        </>,
      ],
    },
    {
      title: 'Managing Your Choices',
      content: [
        <>You can limit interest-based advertising in several ways:</>,
        <ul key="choices">
          <li>
            <strong>Cookie settings</strong> — use controls described in our{' '}
            <Link href="/legal/cookies">Cookie Policy</Link> to disable non-essential advertising cookies
            where available
          </li>
          <li>
            <strong>Industry opt-out tools</strong> — visit the{' '}
            <a href="https://optout.aboutads.info/" target="_blank" rel="noopener noreferrer">
              Digital Advertising Alliance (DAA) opt-out page
            </a>{' '}
            (U.S.) or the{' '}
            <a href="https://youradchoices.ca/" target="_blank" rel="noopener noreferrer">
              Digital Advertising Alliance of Canada
            </a>{' '}
            to opt out of participating companies&apos; interest-based ads on this browser
          </li>
          <li>
            <strong>Mobile devices</strong> — adjust advertising settings on iOS (Settings → Privacy →
            Advertising) or Android (Settings → Google → Ads)
          </li>
          <li>
            <strong>Do Not Sell or Share</strong> — see our{' '}
            <Link href="/legal/do-not-sell">Do Not Sell or Share My Personal Information</Link> page for
            additional rights in certain jurisdictions
          </li>
        </ul>,
        <>
          Opting out does not eliminate advertising; you may still see ads based on the content you are
          reading or general contextual factors.
        </>,
      ],
    },
    {
      title: 'Browser Controls',
      content: [
        <>
          Most browsers allow you to block or delete cookies. Blocking all cookies may affect site
          functionality, including saved preferences. Consult your browser&apos;s help documentation for
          instructions.
        </>,
      ],
    },
    {
      title: 'Contact',
      content: [
        <>
          Questions about advertising on {site.name}:{' '}
          <a href={`mailto:${site.privacyEmail}`}>{site.privacyEmail}</a>.
        </>,
      ],
    },
  ],
};

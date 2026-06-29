import Link from 'next/link';
import type { LegalDocumentData } from '@/content/legal/types';
import { site } from '@/config/site';

export const doNotSellPolicy: LegalDocumentData = {
  title: 'Do Not Sell or Share My Personal Information',
  description:
    'How to opt out of the sale or sharing of personal information for cross-context behavioural advertising.',
  lastUpdated: '26 June 2026',
  sections: [
    {
      title: 'Overview',
      content: [
        <>
          {site.name} respects your privacy choices. Certain privacy laws — including the California
          Consumer Privacy Act (CCPA), as amended by the CPRA — give residents the right to opt out of the
          &ldquo;sale&rdquo; or &ldquo;sharing&rdquo; of personal information. Under these laws,
          &ldquo;sale&rdquo; and &ldquo;sharing&rdquo; can include allowing third parties to receive
          information (such as cookie identifiers, IP addresses, or browsing activity) to deliver
          interest-based advertising.
        </>,
        <>
          This page explains your choices. It should be read with our{' '}
          <Link href="/legal/privacy">Privacy Policy</Link> and{' '}
          <Link href="/legal/cookies">Cookie Policy</Link>.
        </>,
      ],
    },
    {
      title: 'What We May Share',
      content: [
        <>
          As we introduce advertising and analytics partners, we may allow them to collect or receive
          information through cookies, pixels, and similar technologies when you visit our Site. This
          information may be used to measure readership, deliver relevant advertising, and understand
          audience interests.
        </>,
        <>
          We do not sell personal information in exchange for money. Where applicable law treats certain
          advertising disclosures as a &ldquo;sale&rdquo; or &ldquo;sharing&rdquo;, you may opt out as
          described below.
        </>,
      ],
    },
    {
      title: 'How to Opt Out',
      content: [
        <>You may opt out of sale/sharing for interest-based advertising by:</>,
        <ul key="opt-out">
          <li>
            Adjusting cookie preferences through our{' '}
            <Link href="/legal/cookies">Cookie Policy</Link> controls when available on the Site
          </li>
          <li>
            Emailing <a href={`mailto:${site.privacyEmail}`}>{site.privacyEmail}</a> with the subject line
            &ldquo;Do Not Sell or Share&rdquo; and the email address or device you use to visit our Site
          </li>
          <li>
            Enabling the Global Privacy Control (GPC) signal in a supported browser — we honour GPC as an
            opt-out of sale/sharing where required by law
          </li>
        </ul>,
        <>
          Opt-outs are device- and browser-specific because advertising technologies operate at the device
          level. You may need to repeat your choice on other devices or after clearing cookies.
        </>,
      ],
    },
    {
      title: 'Verified Requests',
      content: [
        <>
          California and certain other U.S. state residents may submit a verified request to opt out, know,
          delete, or correct personal information by contacting{' '}
          <a href={`mailto:${site.privacyEmail}`}>{site.privacyEmail}</a>. We will verify your request
          using information associated with your account or recent interactions with our Site where
          necessary.
        </>,
        <>
          We will not discriminate against you for exercising privacy rights granted by applicable law.
        </>,
      ],
    },
    {
      title: 'Changes',
      content: [
        <>
          We may update this notice as our data practices and applicable laws evolve. The &ldquo;Last
          updated&rdquo; date at the top of this page indicates when changes were last made.
        </>,
      ],
    },
  ],
};

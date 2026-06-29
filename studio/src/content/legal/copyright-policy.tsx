import Link from 'next/link';
import type { LegalDocumentData } from '@/content/legal/types';
import { site } from '@/config/site';

export const copyrightPolicy: LegalDocumentData = {
  title: 'Copyright Policy',
  description: 'Copyright ownership, permitted use, and republication of Indian Opinions content.',
  lastUpdated: '26 June 2026',
  sections: [
    {
      title: 'Overview',
      content: [
        <>
          {site.name} (&ldquo;we&rdquo;, &ldquo;us&rdquo;) publishes original journalism, analysis, commentary,
          photography, graphics, audio, video, and other editorial material (collectively, &ldquo;Content&rdquo;)
          on {site.url.replace('https://', '')} and related services.
        </>,
        <>
          Unless otherwise stated, Content is owned by {site.name} or its licensors and is protected by
          copyright, trademark, and other intellectual property laws in India and internationally.
        </>,
      ],
    },
    {
      title: 'Permitted Personal Use',
      content: [
        <>
          You may read, share links to, and reference our articles for personal, non-commercial purposes.
          Brief quotation with clear attribution to {site.name} and a link to the original article is
          generally permitted under fair dealing / fair use principles, provided the excerpt is not
          substantial enough to substitute for the full work.
        </>,
        <>
          You may not reproduce full articles, systematic archives, or substantial portions of Content
          without our prior written permission, except as allowed by applicable law.
        </>,
      ],
    },
    {
      title: 'Republication and Syndication',
      content: [
        <>
          Organisations wishing to republish, translate, broadcast, or otherwise distribute our Content
          must obtain a licence in advance. Requests should include the article title, URL, intended use,
          territory, and duration, and should be sent to{' '}
          <a href={`mailto:${site.privacyEmail}`}>{site.privacyEmail}</a>.
        </>,
        <>
          We reserve the right to approve or decline republication requests at our sole discretion.
          Author bylines and {site.name} branding requirements will apply to any licensed reuse.
        </>,
      ],
    },
    {
      title: 'User-Generated and Third-Party Material',
      content: [
        <>
          Where Content includes material licensed from third parties (for example, wire services,
          photographers, or illustrators), additional restrictions may apply. Third-party trademarks
          and logos remain the property of their respective owners.
        </>,
        <>
          If you submit comments, tips, or other material to us, you grant {site.name} a non-exclusive,
          worldwide, royalty-free licence to use, edit, and publish that material in connection with our
          editorial operations, subject to our{' '}
          <Link href="/legal/privacy">Privacy Policy</Link>.
        </>,
      ],
    },
    {
      title: 'Reporting Copyright Infringement',
      content: [
        <>
          If you believe Content on our Site infringes your copyright, send a written notice to{' '}
          <a href={`mailto:${site.privacyEmail}`}>{site.privacyEmail}</a> including:
        </>,
        <ul key="notice">
          <li>Your name, address, telephone number, and email address</li>
          <li>Identification of the copyrighted work you claim has been infringed</li>
          <li>Identification of the material on our Site and sufficient information to locate it</li>
          <li>
            A statement that you have a good-faith belief that use of the material is not authorised by
            the copyright owner, its agent, or the law
          </li>
          <li>
            A statement, under penalty of perjury where applicable, that the information in your notice is
            accurate and that you are the copyright owner or authorised to act on the owner&apos;s behalf
          </li>
          <li>Your physical or electronic signature</li>
        </ul>,
        <>
          We may remove or disable access to material that is the subject of a valid complaint and may
          terminate repeat infringers where appropriate.
        </>,
      ],
    },
    {
      title: 'Contact',
      content: [
        <>
          Copyright and licensing enquiries:{' '}
          <a href={`mailto:${site.privacyEmail}`}>{site.privacyEmail}</a>.
        </>,
      ],
    },
  ],
};

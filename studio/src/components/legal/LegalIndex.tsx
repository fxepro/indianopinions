import Link from 'next/link';
import { legalDocuments } from '@/config/legal';
import { PageHeader } from '@/components/sections/PageHeader';
import { site } from '@/config/site';

export function LegalIndex() {
  return (
    <article className="legal-page max-w-3xl mx-auto">
      <PageHeader
        title="Legal Policies"
        description={`Policies, notices, and compliance documents governing your use of ${site.name}.`}
        meta="Last updated 26 June 2026"
        size="default"
        className="border-b border-border pb-8 mb-10"
      />

      <ul className="legal-index-list pb-16">
        {legalDocuments.map((doc) => (
          <li key={doc.href} className="legal-index-item">
            <Link href={doc.href} className="legal-index-link">
              {doc.label}
            </Link>
            <p className="legal-index-summary">{doc.summary}</p>
          </li>
        ))}
      </ul>
    </article>
  );
}

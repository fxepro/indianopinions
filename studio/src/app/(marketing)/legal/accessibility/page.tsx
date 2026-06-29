import type { Metadata } from 'next';
import { LegalDocument } from '@/components/legal/LegalDocument';
import { accessibilityStatement } from '@/content/legal/accessibility-statement';
import { site } from '@/config/site';

export const metadata: Metadata = {
  title: `Accessibility | ${site.name}`,
  description: accessibilityStatement.description,
};

export default function AccessibilityPage() {
  return <LegalDocument document={accessibilityStatement} />;
}

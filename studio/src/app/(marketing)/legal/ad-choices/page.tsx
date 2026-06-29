import type { Metadata } from 'next';
import { LegalDocument } from '@/components/legal/LegalDocument';
import { adChoicesPolicy } from '@/content/legal/ad-choices';
import { site } from '@/config/site';

export const metadata: Metadata = {
  title: `Your Ad Choices | ${site.name}`,
  description: adChoicesPolicy.description,
};

export default function AdChoicesPage() {
  return <LegalDocument document={adChoicesPolicy} />;
}

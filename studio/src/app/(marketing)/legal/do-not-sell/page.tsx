import type { Metadata } from 'next';
import { LegalDocument } from '@/components/legal/LegalDocument';
import { doNotSellPolicy } from '@/content/legal/do-not-sell';
import { site } from '@/config/site';

export const metadata: Metadata = {
  title: `Do Not Sell or Share My Personal Information | ${site.name}`,
  description: doNotSellPolicy.description,
};

export default function DoNotSellPage() {
  return <LegalDocument document={doNotSellPolicy} />;
}

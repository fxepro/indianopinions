import type { Metadata } from 'next';
import { LegalDocument } from '@/components/legal/LegalDocument';
import { copyrightPolicy } from '@/content/legal/copyright-policy';
import { site } from '@/config/site';

export const metadata: Metadata = {
  title: `Copyright Policy | ${site.name}`,
  description: copyrightPolicy.description,
};

export default function CopyrightPolicyPage() {
  return <LegalDocument document={copyrightPolicy} />;
}

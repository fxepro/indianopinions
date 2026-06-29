import type { Metadata } from 'next';
import { LegalIndex } from '@/components/legal/LegalIndex';
import { site } from '@/config/site';

export const metadata: Metadata = {
  title: `Legal Policies | ${site.name}`,
  description: 'Index of legal, privacy, and compliance documents for Indian Opinions.',
};

export default function LegalPoliciesPage() {
  return <LegalIndex />;
}

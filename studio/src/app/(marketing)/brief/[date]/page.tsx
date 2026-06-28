import type { Metadata } from 'next';
import { notFound } from 'next/navigation';
import { IntelligenceBriefView } from '@/components/brief/IntelligenceBriefView';
import { getBriefByDate } from '@/lib/api';

type PageProps = {
  params: Promise<{ date: string }>;
};

export async function generateMetadata({ params }: PageProps): Promise<Metadata> {
  const { date } = await params;
  const brief = await getBriefByDate(date);

  if (!brief) {
    return { title: 'Intelligence Brief' };
  }

  return {
    title: `Intelligence Brief · ${brief.edition_label}`,
    description: 'A daily digest of Indian Opinions reporting across every editorial desk.',
  };
}

export default async function BriefDatePage({ params }: PageProps) {
  const { date } = await params;

  if (!/^\d{4}-\d{2}-\d{2}$/.test(date)) {
    notFound();
  }

  const brief = await getBriefByDate(date);

  if (!brief) {
    notFound();
  }

  return <IntelligenceBriefView brief={brief} />;
}

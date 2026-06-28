import { redirect } from 'next/navigation';
import { getLatestBrief } from '@/lib/api';

export default async function BriefIndexPage() {
  const brief = await getLatestBrief();

  if (!brief) {
    redirect('/');
  }

  redirect(`/brief/${brief.edition_date}`);
}

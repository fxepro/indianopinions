import Link from 'next/link';
import { site } from '@/config/site';
import type { IntelligenceBrief } from '@/lib/api';

type IntelligenceBriefViewProps = {
  brief: IntelligenceBrief;
};

export function IntelligenceBriefView({ brief }: IntelligenceBriefViewProps) {
  const isToday =
    brief.edition_date === new Date().toISOString().slice(0, 10);

  return (
    <div className="brief-page section max-w-4xl mx-auto">
      <header className="brief-header">
        <p className="eyebrow mb-3">Intelligence Brief</p>
        <h1 className="brief-title">{isToday ? "Today's Digest" : 'Daily Digest'}</h1>
        <p className="brief-edition">{brief.edition_label}</p>
        <p className="brief-intro">
          Ten stories across our editorial desks — two lead assessments and one dispatch from each hub.
          Read in five minutes; follow the full analysis in our reporting when you need depth.
        </p>
        {(brief.previous_date || brief.next_date) && (
          <nav className="brief-edition-nav" aria-label="Brief editions">
            {brief.previous_date ? (
              <Link href={`/brief/${brief.previous_date}`} className="brief-edition-nav-link">
                ← {formatNavDate(brief.previous_date)}
              </Link>
            ) : (
              <span />
            )}
            {brief.next_date ? (
              <Link href={`/brief/${brief.next_date}`} className="brief-edition-nav-link">
                {formatNavDate(brief.next_date)} →
              </Link>
            ) : (
              <span />
            )}
          </nav>
        )}
      </header>

      <section className="brief-section" aria-labelledby="brief-leads-heading">
        <h2 id="brief-leads-heading" className="brief-section-label">
          Lead Stories
        </h2>
        <div className="brief-leads">
          {brief.leads.map((lead) => (
            <article key={lead.headline} className="brief-lead">
              <h3 className="brief-lead-headline">{lead.headline}</h3>
              <div className="brief-row">
                <div className="brief-row-label">Lead</div>
                <p className="brief-blurb">{lead.blurb}</p>
              </div>
            </article>
          ))}
        </div>
      </section>

      <section className="brief-section" aria-labelledby="brief-hubs-heading">
        <h2 id="brief-hubs-heading" className="brief-section-label">
          Across the Desks
        </h2>
        <div className="brief-hub-list">
          {brief.hubs.map((item) => (
            <article key={item.hub_slug} className="brief-row brief-hub-row">
              <div className="brief-row-label">{item.hub}</div>
              <p className="brief-blurb">{item.blurb}</p>
            </article>
          ))}
        </div>
      </section>

      <footer className="brief-caveat">
        <p>{brief.caveat}</p>
        <p className="brief-caveat-brand">{site.name} · Editorial Standards Apply</p>
      </footer>
    </div>
  );
}

function formatNavDate(iso: string): string {
  return new Date(`${iso}T12:00:00`).toLocaleDateString('en-GB', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  });
}

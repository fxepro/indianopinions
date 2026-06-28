import { notFound } from 'next/navigation';
import { ArticleCard } from '@/components/editorial/ArticleCard';
import { WeeklyLetter } from '@/components/editorial/WeeklyLetter';
import { getHub } from '@/config/hubs';
import {
  ApiArticle,
  articleCategory,
  formatArticleDate,
  getHubLayout,
} from '@/lib/api';

function toCardProps(article: ApiArticle) {
  return {
    slug: article.slug,
    category: articleCategory(article),
    title: article.title,
    excerpt: article.excerpt || '',
    author: article.author,
    date: formatArticleDate(article.published_at) || article.reading_time_label || '',
    image: article.featured_image || undefined,
  };
}

export default async function HubPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const hub = getHub(slug);

  if (!hub) {
    notFound();
  }

  const layout = await getHubLayout(slug);
  const hero = layout?.sections.hero?.items[0];
  const grid = layout?.sections.grid?.items ?? [];
  const latest = layout?.sections.latest?.items ?? [];

  return (
    <>
      <header className="section mb-8 border-b border-border pb-12 max-w-4xl">
        <span className="eyebrow mb-4 inline-block">Intelligence Hub</span>
        <h1 className="text-6xl md:text-8xl font-bold mb-6 tracking-tighter">{hub.title}</h1>
        <p className="text-xl md:text-2xl text-muted-foreground leading-relaxed font-headline italic">
          {hub.description}
        </p>
      </header>

      {hero && (
        <section className="section">
          <ArticleCard {...toCardProps(hero)} layout="featured" />
        </section>
      )}

      {grid.length > 0 && (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12 section">
          {grid.map((article) => (
            <ArticleCard key={article.id} {...toCardProps(article)} />
          ))}
        </div>
      )}

      {latest.length > 0 && (
        <section className="section">
          <h2 className="section-heading">More in {hub.title}</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-x-12">
            {latest.map((article) => (
              <ArticleCard key={article.id} {...toCardProps(article)} />
            ))}
          </div>
        </section>
      )}

      <WeeklyLetter />
    </>
  );
}

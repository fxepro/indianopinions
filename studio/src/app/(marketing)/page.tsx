import { ArticleCard } from '@/components/editorial/ArticleCard';
import { DataLabModule } from '@/components/editorial/DataLabModule';
import { WeeklyLetter } from '@/components/editorial/WeeklyLetter';
import {
  ApiArticle,
  articleCategory,
  formatArticleDate,
  getHomepageLayout,
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

export default async function Home() {
  const layout = await getHomepageLayout();
  const hero = layout?.sections.hero?.items[0];
  const strategic = layout?.sections.strategic_analysis?.items ?? [];
  const brief = layout?.sections.daily_brief?.items ?? [];
  const latest = layout?.sections.latest?.items ?? [];

  return (
    <>
      {hero && (
        <section className="section">
          <ArticleCard {...toCardProps(hero)} layout="featured" />
        </section>
      )}

      <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 section">
        <div className="lg:col-span-8">
          {strategic.length > 0 && (
            <>
              <h2 className="section-heading">Strategic Analysis</h2>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-x-12">
                {strategic.map((article) => (
                  <ArticleCard key={article.id} {...toCardProps(article)} />
                ))}
              </div>
            </>
          )}

          {latest.length > 0 && (
            <div className="mt-12">
              <h2 className="section-heading">More Stories</h2>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-x-12">
                {latest.map((article) => (
                  <ArticleCard key={article.id} {...toCardProps(article)} />
                ))}
              </div>
            </div>
          )}

          <div className="cta-band mt-12">
            <div className="flex-1">
              <h3 className="text-xl font-bold mb-2">The Intelligence Network</h3>
              <p className="text-sm text-muted-foreground leading-relaxed">
                Join our pool of contributing analysts, diplomats, and industry leaders. We value qualitative rigor over quantitative noise.
              </p>
            </div>
            <button type="button" className="btn-primary whitespace-nowrap">
              Submit Thesis
            </button>
          </div>
        </div>

        <aside className="sidebar-panel lg:col-span-4">
          {brief.length > 0 && (
            <>
              <h2 className="section-heading text-accent border-accent/20">The Daily Brief</h2>
              <div className="space-y-2">
                {brief.map((article) => (
                  <ArticleCard key={article.id} {...toCardProps(article)} layout="minimal" />
                ))}
              </div>
            </>
          )}

          <div className="quote-panel">
            <h4 className="font-headline font-bold text-lg mb-2">Strategy Note</h4>
            <p className="text-sm italic text-muted-foreground mb-4 leading-relaxed">
              &ldquo;In foreign policy, there are no permanent friends or enemies, only permanent interests.&rdquo;
            </p>
            <div className="eyebrow text-[10px]">— Editorial Board, IndianOpinions</div>
          </div>
        </aside>
      </div>

      <DataLabModule />
      <WeeklyLetter />
    </>
  );
}

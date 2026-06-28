import Image from 'next/image';
import { notFound } from 'next/navigation';
import { articleCategory, formatArticleDate, getArticle } from '@/lib/api';

export default async function ArticlePage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const article = await getArticle(slug);

  if (!article) {
    notFound();
  }

  return (
    <article className="section max-w-4xl mx-auto">
      <span className="eyebrow mb-4 inline-block">{articleCategory(article)}</span>
      <h1 className="text-5xl md:text-6xl font-bold mb-6 tracking-tight">{article.title}</h1>
      <p className="text-sm font-bold uppercase tracking-widest text-muted-foreground mb-8">
        By {article.author}
        {article.published_at && (
          <>
            {' '}
            · {formatArticleDate(article.published_at)}
          </>
        )}
      </p>

      {article.featured_image && (
        <div className="aspect-[16/9] relative mb-10">
          <Image src={article.featured_image} alt={article.title} fill className="object-cover" />
        </div>
      )}

      {article.excerpt && (
        <p className="text-xl text-muted-foreground leading-relaxed mb-10 font-headline italic">
          {article.excerpt}
        </p>
      )}

      {article.content && (
        <div
          className="prose prose-lg max-w-none"
          dangerouslySetInnerHTML={{ __html: article.content }}
        />
      )}
    </article>
  );
}

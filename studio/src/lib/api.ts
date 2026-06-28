export type ApiCategory = {
  id: number;
  name: string;
  slug: string;
  color?: string;
};

export type ApiArticle = {
  id: number;
  title: string;
  slug: string;
  excerpt: string | null;
  content?: string | null;
  featured_image: string | null;
  author: string;
  reading_time_label?: string;
  published_at: string | null;
  categories?: ApiCategory[];
  curated?: boolean;
};

export type LayoutSection = {
  label: string;
  description?: string | null;
  items: ApiArticle[];
};

export type PageLayout = {
  page: string;
  hub_slug?: string | null;
  sections: Record<string, LayoutSection>;
};

const API_URL = process.env.NEXT_PUBLIC_API_URL || process.env.API_URL || 'http://localhost:8000';

async function fetchJson<T>(path: string): Promise<T | null> {
  try {
    const response = await fetch(`${API_URL}${path}`, {
      next: { revalidate: 60 },
    });

    if (!response.ok) {
      return null;
    }

    return response.json() as Promise<T>;
  } catch {
    return null;
  }
}

export function getHomepageLayout(): Promise<PageLayout | null> {
  return fetchJson<PageLayout>('/api/layout/homepage');
}

export function getHubLayout(slug: string): Promise<PageLayout | null> {
  return fetchJson<PageLayout>(`/api/layout/hubs/${slug}`);
}

export function getArticle(slug: string): Promise<ApiArticle | null> {
  return fetchJson<ApiArticle>(`/api/articles/${slug}`);
}

export function formatArticleDate(iso: string | null | undefined): string {
  if (!iso) {
    return '';
  }

  return new Date(iso).toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric',
  });
}

export function articleCategory(article: ApiArticle): string {
  return article.categories?.[0]?.name || 'Indian Opinions';
}

export function articleHref(slug: string): string {
  return `/article/${slug}`;
}

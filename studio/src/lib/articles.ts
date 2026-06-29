import type { ApiArticle } from '@/lib/api';
import { getApiUrl } from '@/lib/api-url';

export async function getArticlesByCategory(
  category: string,
  perPage = 50,
): Promise<ApiArticle[]> {
  const apiUrl = getApiUrl();

  try {
    const response = await fetch(
      `${apiUrl}/api/articles?category=${encodeURIComponent(category)}&per_page=${perPage}`,
      { next: { revalidate: 60 } },
    );

    if (!response.ok) {
      return [];
    }

    const payload = (await response.json()) as { data?: ApiArticle[] };
    return payload.data ?? [];
  } catch {
    return [];
  }
}

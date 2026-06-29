/**
 * Laravel API base URL.
 * Server components prefer API_URL (runtime on Netlify).
 * Client code uses NEXT_PUBLIC_API_URL (inlined at build).
 */
export function getApiUrl(): string {
  if (typeof window === 'undefined' && process.env.API_URL) {
    return process.env.API_URL.replace(/\/$/, '');
  }

  const url = process.env.NEXT_PUBLIC_API_URL || process.env.API_URL || 'http://localhost:8000';

  return url.replace(/\/$/, '');
}

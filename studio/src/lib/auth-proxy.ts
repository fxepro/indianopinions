import {NextResponse} from 'next/server';

import {getApiUrl} from '@/lib/api-url';

export function stripCookieDomain(setCookie: string): string {
  return setCookie.replace(/;\s*Domain=[^;]*/gi, '');
}

export function forwardSetCookies(target: NextResponse, setCookies: string[]): void {
  for (const raw of setCookies) {
    target.headers.append('Set-Cookie', stripCookieDomain(raw));
  }
}

export function extractCsrfToken(html: string): string | null {
  const match = html.match(/name="_token" value="([^"]+)"/);

  return match?.[1] ?? null;
}

export function isAuthSuccessRedirect(location: string): boolean {
  if (location === '') {
    return false;
  }

  let path: string;

  try {
    path = location.startsWith('http://') || location.startsWith('https://')
      ? new URL(location).pathname
      : location.split('?')[0];
  } catch {
    return false;
  }

  if (!path.startsWith('/')) {
    path = `/${path}`;
  }

  return (
    path.startsWith('/admin') &&
    path !== '/admin/login' &&
    !path.startsWith('/admin/login/')
  );
}

/** Map Laravel redirect target to a same-origin path on the public site. */
export function toPublicRedirectPath(location: string): string | null {
  if (!isAuthSuccessRedirect(location)) {
    return null;
  }

  try {
    if (location.startsWith('http://') || location.startsWith('https://')) {
      const parsed = new URL(location);
      return parsed.pathname + parsed.search;
    }
  } catch {
    return null;
  }

  return location.startsWith('/') ? location : `/${location}`;
}

/** @deprecated Use toPublicRedirectPath */
export function toPublicPath(location: string, requestUrl: string): string {
  return toPublicRedirectPath(location) ?? new URL('/admin/posts', requestUrl).pathname;
}

export function getApiOrigin(): string {
  return getApiUrl().replace(/\/$/, '');
}

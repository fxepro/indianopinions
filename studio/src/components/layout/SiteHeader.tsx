'use client';

import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { primaryNav } from '@/config/navigation';
import { site } from '@/config/site';

export function SiteHeader() {
  const pathname = usePathname();
  const today = new Date().toLocaleDateString('en-GB', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });

  return (
    <header className="site-header">
      <div className="container-app site-header-inner">
        <div className="site-header-meta">
          <span>{site.mastheadLine}</span>
          <span className="site-header-meta-accent">{site.mastheadTagline}</span>
          <span>{site.editions}</span>
        </div>

        <Link href="/" className="site-logo-link">
          <h1 className="site-logo">{site.name}</h1>
          <p className="site-tagline">{site.tagline}</p>
        </Link>

        <div className="site-header-rule">
          <span className="site-header-rule-side">{site.volume}</span>
          <span className="site-header-date">{today}</span>
          <Link
            href="/brief"
            className={`site-header-rule-side site-header-brief-link${
              pathname === '/brief' || pathname.startsWith('/brief/') ? ' site-header-brief-link-active' : ''
            }`}
          >
            Intelligence Brief
          </Link>
        </div>

        <nav className="site-nav" aria-label="Primary">
          {primaryNav.map((item) => {
            const active = pathname === item.href || pathname.startsWith(`${item.href}/`);
            return (
              <Link
                key={item.href}
                href={item.href}
                className={`site-nav-link${active ? ' site-nav-link-active' : ''}`}
                aria-current={active ? 'page' : undefined}
              >
                {item.label}
              </Link>
            );
          })}
        </nav>
      </div>
    </header>
  );
}

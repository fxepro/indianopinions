import Link from 'next/link';
import { footerLegalLinks } from '@/config/footer';
import { site } from '@/config/site';

export function SiteFooter() {
  return (
    <footer className="site-footer">
      <div className="container-app site-footer-inner">
        <div className="site-footer-brand">
          <h2 className="site-footer-logo">{site.name}</h2>
          <p className="site-footer-legal">{site.footerLegal}</p>
        </div>
        <nav className="site-footer-nav" aria-label="Footer">
          {footerLegalLinks.map((link) => (
            <Link key={link.href} href={link.href} className="site-footer-link">
              {link.label}
            </Link>
          ))}
        </nav>
      </div>
    </footer>
  );
}

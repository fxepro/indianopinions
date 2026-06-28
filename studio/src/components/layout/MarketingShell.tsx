import { SiteHeader } from '@/components/layout/SiteHeader';
import { SiteFooter } from '@/components/layout/SiteFooter';

type MarketingShellProps = {
  children: React.ReactNode;
};

/** Public marketing shell — owns header, main, footer chrome. */
export function MarketingShell({ children }: MarketingShellProps) {
  return (
    <>
      <SiteHeader />
      <main className="page-main">
        <div className="page-body container-app">{children}</div>
      </main>
      <SiteFooter />
    </>
  );
}

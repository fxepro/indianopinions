import type {NextConfig} from 'next';

const backendUrl =
  process.env.API_URL ??
  process.env.NEXT_PUBLIC_API_URL ??
  'http://localhost:8000';

const adminLoginUrl =
  process.env.NEXT_PUBLIC_ADMIN_URL ?? 'http://localhost:8000/admin/login';

/** Local dev only — production proxies /admin/* to Railway via rewrites below. */
function adminLoginRedirect() {
  try {
    const target = new URL(adminLoginUrl);
    if (target.hostname !== 'localhost') {
      return [];
    }
  } catch {
    return [];
  }

  return [
    {
      source: '/admin/login',
      destination: adminLoginUrl,
      permanent: false,
    },
  ];
}

const nextConfig: NextConfig = {
  async redirects() {
    return adminLoginRedirect();
  },
  async rewrites() {
    return [
      {source: '/admin', destination: `${backendUrl}/admin`},
      {source: '/admin/:path*', destination: `${backendUrl}/admin/:path*`},
      {source: '/build/:path*', destination: `${backendUrl}/build/:path*`},
      {source: '/login', destination: `${backendUrl}/login`},
      {source: '/logout', destination: `${backendUrl}/logout`},
      {source: '/storage/:path*', destination: `${backendUrl}/storage/:path*`},
    ];
  },
  /* config options here */
  typescript: {
    ignoreBuildErrors: true,
  },
  eslint: {
    ignoreDuringBuilds: true,
  },
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'placehold.co',
        port: '',
        pathname: '/**',
      },
      {
        protocol: 'https',
        hostname: 'images.unsplash.com',
        port: '',
        pathname: '/**',
      },
      {
        protocol: 'https',
        hostname: 'picsum.photos',
        port: '',
        pathname: '/**',
      },
    ],
  },
};

export default nextConfig;

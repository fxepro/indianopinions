import type {NextConfig} from 'next';

const adminLoginUrl =
  process.env.NEXT_PUBLIC_ADMIN_URL ?? 'http://localhost:8000/admin/login';

/** Local dev only — production serves /admin/* via Netlify proxy to Railway. */
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

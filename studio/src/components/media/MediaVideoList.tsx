'use client';

import {useMemo, useState} from 'react';

import type {ApiMediaVideo} from '@/lib/api';

import {VideoModal} from './VideoModal';
import {VideoRow} from './VideoRow';

type MediaVideoListProps = {
  videos: ApiMediaVideo[];
};

export function MediaVideoList({videos}: MediaVideoListProps) {
  const [active, setActive] = useState<ApiMediaVideo | null>(null);

  const ordered = useMemo(() => {
    const featured = videos.find((video) => video.featured);
    if (!featured) {
      return videos;
    }

    return [featured, ...videos.filter((video) => video.id !== featured.id)];
  }, [videos]);

  return (
    <>
      <section className="section">
        <div className="media-grid">
          {ordered.map((video) => (
            <VideoRow key={video.id} video={video} onPlay={setActive} />
          ))}
        </div>
      </section>

      <VideoModal video={active} onClose={() => setActive(null)} />
    </>
  );
}

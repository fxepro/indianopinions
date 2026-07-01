'use client';

import type {ApiMediaVideo} from '@/lib/api';

function formatDuration(seconds: number | null): string {
  if (!seconds || seconds <= 0) {
    return '';
  }

  const hrs = Math.floor(seconds / 3600);
  const mins = Math.floor((seconds % 3600) / 60);
  const secs = seconds % 60;

  if (hrs > 0) {
    return `${hrs}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
  }

  return `${mins}:${secs.toString().padStart(2, '0')}`;
}

type VideoRowProps = {
  video: ApiMediaVideo;
  onPlay: (video: ApiMediaVideo) => void;
};

export function VideoRow({video, onPlay}: VideoRowProps) {
  const title = video.title?.trim() || 'Untitled video';
  const duration = formatDuration(video.duration_seconds);

  return (
    <article className="media-card">
      <button
        type="button"
        className="media-row-thumb"
        onClick={() => onPlay(video)}
        aria-label={`Play ${title}`}
      >
        {video.thumbnail_url ? (
          // eslint-disable-next-line @next/next/no-img-element
          <img src={video.thumbnail_url} alt="" className="media-row-thumb-image" />
        ) : (
          <span className="media-row-thumb-fallback">Video</span>
        )}
        <span className="media-row-play" aria-hidden="true">
          ▶
        </span>
        {duration ? <span className="media-row-duration">{duration}</span> : null}
      </button>

      <div className="media-row-body">
        <button type="button" className="media-row-title" onClick={() => onPlay(video)}>
          {title}
        </button>
        {video.category ? <p className="media-row-category">{video.category}</p> : null}
        {video.description ? <p className="media-row-description">{video.description}</p> : null}
        {video.provider !== 'file' ? (
          <p className="media-row-meta">{video.provider === 'youtube' ? 'YouTube' : 'Vimeo'}</p>
        ) : null}
      </div>
    </article>
  );
}

'use client';

import {useCallback, useEffect} from 'react';

import type {ApiMediaVideo} from '@/lib/api';

type VideoModalProps = {
  video: ApiMediaVideo | null;
  onClose: () => void;
};

export function VideoModal({video, onClose}: VideoModalProps) {
  const handleKeyDown = useCallback(
    (event: KeyboardEvent) => {
      if (event.key === 'Escape') {
        onClose();
      }
    },
    [onClose],
  );

  useEffect(() => {
    if (!video) {
      return;
    }

    document.addEventListener('keydown', handleKeyDown);
    document.body.style.overflow = 'hidden';

    return () => {
      document.removeEventListener('keydown', handleKeyDown);
      document.body.style.overflow = '';
    };
  }, [video, handleKeyDown]);

  if (!video) {
    return null;
  }

  const title = video.title?.trim() || 'Untitled video';

  return (
    <div
      className="video-modal-backdrop"
      role="dialog"
      aria-modal="true"
      aria-label={title}
      onClick={onClose}
    >
      <div className="video-modal-panel" onClick={(event) => event.stopPropagation()}>
        <button type="button" className="video-modal-close" onClick={onClose}>
          Close
        </button>
        <p className="video-modal-title">{title}</p>
        <div className="video-modal-player">
          {video.embed_url ? (
            <iframe
              src={`${video.embed_url}?autoplay=1`}
              title={title}
              className="video-modal-embed"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowFullScreen
            />
          ) : (
            <video
              key={video.id}
              src={video.video_url}
              className="video-modal-file"
              controls
              autoPlay
              playsInline
            />
          )}
        </div>
      </div>
    </div>
  );
}

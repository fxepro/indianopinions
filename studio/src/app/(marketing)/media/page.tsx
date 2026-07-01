import {MediaVideoList} from '@/components/media/MediaVideoList';
import {EmptyState} from '@/components/sections/EmptyState';
import {getMediaVideos} from '@/lib/api';

export default async function MediaPage() {
  const videos = await getMediaVideos();

  return (
    <div className="media-page">
      {!videos.length ? (
        <EmptyState
          title="No videos yet"
          message="Editorial video will appear here once published from the admin Videos library."
          action={{label: 'Back to homepage', href: '/'}}
        />
      ) : (
        <MediaVideoList videos={videos} />
      )}
    </div>
  );
}

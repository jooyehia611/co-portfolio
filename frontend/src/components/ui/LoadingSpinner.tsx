export function LoadingSpinner() {
  return (
    <div className="yt-loader" role="status" aria-live="polite">
      <span className="yt-loader__ring" />
      <span className="sr-only">Loading</span>
    </div>
  );
}

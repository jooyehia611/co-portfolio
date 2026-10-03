import {
  createContext,
  useCallback,
  useContext,
  useLayoutEffect,
  useMemo,
  useState,
  type ReactNode,
} from 'react';

interface ContentGateValue {
  contentReady: boolean;
  beginLoading: () => void;
  endLoading: () => void;
}

const ContentGateContext = createContext<ContentGateValue | null>(null);

export function ContentGateProvider({ children }: { children: ReactNode }) {
  const [pending, setPending] = useState(0);

  const beginLoading = useCallback(() => {
    setPending((count) => count + 1);
  }, []);

  const endLoading = useCallback(() => {
    setPending((count) => Math.max(0, count - 1));
  }, []);

  const value = useMemo(
    () => ({
      contentReady: pending === 0,
      beginLoading,
      endLoading,
    }),
    [pending, beginLoading, endLoading],
  );

  return (
    <ContentGateContext.Provider value={value}>{children}</ContentGateContext.Provider>
  );
}

export function useContentGate() {
  const ctx = useContext(ContentGateContext);
  if (!ctx) {
    return {
      contentReady: true,
      beginLoading: () => undefined,
      endLoading: () => undefined,
    };
  }
  return ctx;
}

/** Registers a full-page load blocker before paint. */
export function useContentLoading(isLoading: boolean) {
  const { beginLoading, endLoading } = useContentGate();

  useLayoutEffect(() => {
    if (!isLoading) return;
    beginLoading();
    return () => endLoading();
  }, [isLoading, beginLoading, endLoading]);
}

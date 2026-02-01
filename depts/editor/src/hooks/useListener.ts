import {useEffect} from "react";

export function useListener(name: string, listener: (event: CustomEvent) => void) {
  useEffect(() => {
    const ctr = new AbortController();

    window.addEventListener(name, listener as EventListener, {
      signal: ctr.signal,
    });

    return () => {
      ctr.abort();
    }
  }, []);
}

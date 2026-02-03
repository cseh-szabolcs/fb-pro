import {useCallback, type KeyboardEvent} from "react";
import {useToggleMark} from "./useMark.ts";

export function useShortcuts() {
  const toggleMark = useToggleMark();

  return useCallback((event: KeyboardEvent) => {

    if (!event.ctrlKey) return;

    switch (event.key) {
      case 'b': {
        event.preventDefault();
        toggleMark('bold');
        break;
      }
      case 'i': {
        event.preventDefault();
        toggleMark('italic');
        break;
      }
    }
  }, []);
}
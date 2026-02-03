import {useCallback, type KeyboardEvent} from "react";
import {useToggleMark} from "app/components/Editor/hooks/useMark.ts";

export function useShortCuts() {
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
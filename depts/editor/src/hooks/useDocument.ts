import {useAppSelector} from "app/store";
import {selectDocumentId} from "app/store/slice/mainSlice.ts";
import {selectById} from "app/store/slice/elementSlice.ts";
import type {Element} from "app/types/element";

export function useDocument(): Element {
  const documentId = useAppSelector(selectDocumentId);

  return useAppSelector(state => selectById(state, documentId));
}

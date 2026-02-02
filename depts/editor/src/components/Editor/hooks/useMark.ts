import type {MarkTypes} from "app/types/editor.ts";
import {Editor} from "slate";
import {useEditor} from "./useEditor.ts";

export function useMark(format: MarkTypes): [() => void, boolean] {
  const toggle = useToggleMark(format);
  const isValue = useIsMarkActive(format);

  return [
    toggle,
    isValue,
  ];
}

export function useToggleMark(format: MarkTypes) {
  const editor = useEditor();

  return () => {
    const isActive = isMarkActive(editor, format);

    if (isActive) {
      Editor.removeMark(editor, format);
    } else {
      Editor.addMark(editor, format, true);
    }
  };
}

export function useIsMarkActive(format: MarkTypes) {
  const editor = useEditor();
  return isMarkActive(editor, format);
}

const isMarkActive = (editor: Editor, format: MarkTypes): boolean => {
  const marks = Editor.marks(editor);

  return !!marks?.[format];
};
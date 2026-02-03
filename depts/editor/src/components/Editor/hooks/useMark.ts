import type {MarkTypes} from "app/types/editor.ts";
import {Editor} from "slate";
import {useEditor} from "./useEditor.ts";

export function useMark(format: MarkTypes): [() => void, boolean] {
  const toggle = useToggleMark();
  const isValue = useIsMarkActive(format);

  const toggleFormat = () => toggle(format);

  return [
    toggleFormat,
    isValue,
  ];
}

export function useToggleMark() {
  const editor = useEditor();

  return (format: MarkTypes) => {
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

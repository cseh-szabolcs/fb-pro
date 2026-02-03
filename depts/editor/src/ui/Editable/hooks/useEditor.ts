import type {Editor} from "slate";
import {useSlate, useSlateStatic} from "slate-react";

export function useEditor(): Editor {
  return useSlate();
}

export function useEditorStatic(): Editor {
  return useSlateStatic();
}

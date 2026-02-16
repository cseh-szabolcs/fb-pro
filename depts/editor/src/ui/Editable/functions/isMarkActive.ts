import {Editor} from "slate";
import type {MarkTypes} from "app/types/editor.ts";

export const isMarkActive = (editor: Editor, format: MarkTypes): boolean => {
    const marks = Editor.marks(editor);

    return !!marks?.[format];
};

import {Editor} from "slate";
import type {EElement} from "app/types/editor.ts";

export function getCurrentBlock(editor: Editor) {
    if (!editor.selection) {
        return;
    }

    const match = Editor.above(editor, {
        at: editor.selection,
        match: (node) => Editor.isBlock(editor, node as EElement),
        mode: 'lowest',
    });

    if (match) {
        const [node] = match;

        return node as EElement;
    }
}

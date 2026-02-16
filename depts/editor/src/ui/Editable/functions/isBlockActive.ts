import {Editor, Element} from "slate";
import {objectIntersects} from "app/functions/objectIntersects.ts";
import type {EElement} from "app/types/editor.ts";
import type {RequireOne} from "app/types/common.ts";

type Editable = Pick<EElement, 'type' | 'align'>;
type Props = RequireOne<Editable>;

export function isBlockActive(editor: Editor, props: Props){
    if (!editor.selection) {
        return false;
    }

    return Array.from(Editor.nodes(editor, {
        at: Editor.unhangRange(editor, editor.selection),
        match: (node) => !Editor.isEditor(node)
            && Element.isElement(node)
            && objectIntersects(props, node)
        ,
    })).length > 0;
}

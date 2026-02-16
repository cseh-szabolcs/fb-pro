import type {EElement} from "app/types/editor.ts";
import {Editor, Transforms} from "slate";
import type {RequireOne} from "app/types/common.ts";

type Editable = Pick<EElement, 'type' | 'align'>;
type Props = RequireOne<Editable>;

export function toggleBlock(editor: Editor, props: Partial<EElement>, isActive?: boolean) {
    if (isActive === true) {
        Object.entries(props).forEach(([key]) => {
            props[key as keyof Props] = undefined;
        });
    }

    return () => Transforms.setNodes<Editor>(editor, props);
}

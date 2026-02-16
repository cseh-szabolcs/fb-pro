import {useEditor} from "app/ui/Editable/hooks/useEditor.ts";
import {isBlockActive} from "app/ui/Editable/functions/isBlockActive.ts";
import {toggleBlock} from "app/ui/Editable/functions/toggleBlock.ts";
import {getCurrentBlock} from "app/ui/Editable/functions/getCurrentBlock.ts";
import {objectOmit} from "app/functions/objectOmit.ts";
import type {BaseElement, EElement, ElementTypes} from "app/types/editor.ts";
import type {RequireOne} from "app/types/common.ts";

type Editable = Pick<EElement, 'type' | 'align'>;
type Props = RequireOne<Editable>;

export function useBlock(props: Props): [() => void, boolean] {
  const editor = useEditor();
  const isActive = isBlockActive(editor, props);

  return [
    toggleBlock(editor, props, isActive),
    isActive,
  ];
}

export function useGetCurrentBlock():[
  <T extends BaseElement>(type:ElementTypes, props?: Partial<Omit<T,  'type' | 'children'>>) => void,
  Omit<EElement, 'children'>|undefined
] {
  const editor = useEditor();
  const block = getCurrentBlock(editor);

  const picked = block ? objectOmit(block, ['children']) : undefined

  return [
    (type, props = {})=> toggleBlock(editor, {...props, type})(),
    picked,
  ];
}

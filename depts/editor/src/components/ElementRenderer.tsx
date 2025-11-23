import {useMemo, type ReactNode} from "react";
import {selectById} from "app/store/slice/elementSlice.ts";
import {useAppSelector} from "app/store";
import {Document, Page, View} from "app/components/Element";
import type {Element as TElement} from "app/types/element";
import type {Document as TDocument} from "app/types/element";
import type {Page as TPage} from "app/types/element";
import type {View as TView} from "app/types/element";

function Element({element, parent, children}: {
  element: TElement;
  parent?: TElement;
  children?: ReactNode;
}) {

  switch (element.type) {
    case 'document':
      return (
        <Document element={element as TDocument} parent={parent} children={children} />
      );
    case 'page':
      return (
        <Page element={element as TPage} parent={parent} children={children} />
      );
    case 'view':
      return (
        <View element={element as TView} parent={parent} children={children} />
      );
    default:
      return null;
  }
}

export function ElementRenderer({elementId, parent}: {
  elementId: string;
  parent?: TElement;
}) {
  const element = useAppSelector(state => selectById(state, elementId));

  const children = useMemo(() => element.children.map(childId => (
    <ElementRenderer key={childId} elementId={childId} parent={element} />
  )), [element]);

  return (
    <Element element={element} parent={parent} children={children} />
  );
}

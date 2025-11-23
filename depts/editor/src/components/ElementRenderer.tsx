import {selectById} from "app/store/slice/elementSlice.ts";
import {useAppSelector} from "app/store";
import {Document, Page, View} from "app/components/Element";
import type {Document as TDocument} from "app/types/element";
import type {Page as TPage} from "app/types/element";
import type {View as TView} from "app/types/element";

export function ElementRenderer({elementId}: {
  elementId: string;
}) {
  const element = useAppSelector(state => selectById(state, elementId));

  const children = element.children.map(childId => (
    <ElementRenderer key={childId} elementId={childId} />
  ));

  switch (element.type) {
    case 'document':
      return (
        <Document element={element as TDocument} children={children} />
      );
    case 'page':
      return (
        <Page element={element as TPage} children={children} />
      );
    case 'view':
      return (
        <View element={element as TView} children={children} />
      );
    default:
      return null;
  }
}

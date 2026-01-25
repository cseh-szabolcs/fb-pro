import {useMemo} from "react";
import {selectById} from "app/store/slice/elementSlice.ts";
import {useAppSelector} from "app/store";
import {Element} from "./Element.tsx";
import type {Element as TElement} from "app/types/element.ts";

export function FixturesRenderer({elementId, parent}: {
  elementId: string;
  parent?: TElement;
}) {

  const element = useAppSelector(
    state => selectById(state, elementId),
  );

  const children = useMemo(() => element.children.map(childId => (
    <FixturesRenderer key={childId} elementId={childId} parent={element} />
  )), [element]);

  return (
    <Element element={element} parent={parent} children={children} />
  );
}

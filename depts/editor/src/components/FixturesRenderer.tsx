import {useMemo} from "react";
import {selectById} from "app/store/slice/fixtureSlice.ts";
import {useAppSelector} from "app/store";
import type {Element as TElement} from "app/types/element.ts";
import {FixtureElement} from "app/components/Fixtures/FixtureElement.tsx";

export function FixturesRenderer({elementId = 'root', parent}: {
  elementId?: string;
  parent?: TElement;
}) {

  const element = useAppSelector(
    state => selectById(state, elementId),
  );

  const children = useMemo(() => element.children.map(childId => (
    <FixturesRenderer key={childId} elementId={childId} parent={element} />
  )), [element]);

  if (elementId === 'root') {
    return children;
  }

  return (
    <FixtureElement
      element={element}
      parent={parent}
      children={children}
    />
  );
}

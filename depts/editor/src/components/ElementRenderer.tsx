import {useMemo} from "react";
import {selectById} from "app/store/slice/elementSlice.ts";
import {useAppSelector} from "app/store";
import {Element} from "./Element/Element.tsx";
import {ElementOuter} from "app/components/Element/ElementOuter.tsx";
import {Controls} from "app/components/Element/Controls.tsx";
import type {Element as TElement} from "app/types/element.ts";

export function ElementRenderer({elementId, parent}: {
  elementId: string;
  parent?: TElement;
}) {

  const element = useAppSelector(
    state => selectById(state, elementId),
  );

  const children = useMemo(() => element.children.map(childId => (
    <ElementRenderer
      key={childId}
      elementId={childId}
      parent={element}
    />
  )), [element]);

  return (
    <ElementOuter margin={element.margin}>
        <Controls>
          <Element
            element={element}
            parent={parent}
            children={children}
          />
      </Controls>
    </ElementOuter>
  );
}

import type {ReactNode, MouseEvent} from "react";
import {useGetActiveElement, useSetActiveElement} from "app/hooks/useActiveElement.ts";
import type {Element} from "app/types/element.ts";

export function Controls({element, children}: {
  element: Element
  children: ReactNode;
}) {

  const activeElement = useGetActiveElement();
  const setActiveElement = useSetActiveElement();
  const isActive = activeElement?.uuid === element?.uuid;

  const handleSetActiveElement = (e: MouseEvent) => {
    e.stopPropagation();
    setActiveElement(element.uuid);
  };

  return (
    <div style={{border:`4px solid ${isActive ? 'cyan' : 'blue'}`}} data-id={element?.uuid} onClick={handleSetActiveElement}>
      {children}
    </div>
  );
}

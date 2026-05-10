import type {ReactNode, MouseEvent} from "react";
import {useGetActiveElement, useSetActiveElement} from "app/hooks/useActiveElement.ts";
import type {Element} from "app/types/element.ts";

export function Controls({element, children}: {
  element: Element
  children: ReactNode;
}) {

  const activeElement = useGetActiveElement();
  const setActiveElement = useSetActiveElement();
  const isActive = activeElement?.id === element?.id;

  const handleSetActiveElement = (e: MouseEvent) => {
    e.stopPropagation();
    setActiveElement(element.id);
  };

  return (
    <div style={{border:`4px solid ${isActive ? 'cyan' : 'blue'}`}} data-id={element?.id} onClick={handleSetActiveElement}>
      {children}
    </div>
  );
}

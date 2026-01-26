import type {ReactNode} from "react";
import {useElementContext} from "app/components/Element/ElementContext.tsx";

export function Controls({children}: {
  children: ReactNode;
}) {

  const element = useElementContext();
  if (!element) {
    return <>{children}</>;
  }

  return (
    <div style={{border:"2px dashed cyan"}} data-id={element?.uuid}>
      {children}
    </div>
  );
}

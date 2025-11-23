import {type ReactNode} from "react";
import {type View as TView} from "app/types/element";

export function View({element, children}: {
  element: TView;
  children?: ReactNode;
}) {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '1px solid lime', margin: 20, padding: 20}}>
      {children}
    </div>
  );
}

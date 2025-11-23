import {type ReactNode} from "react";
import {type Element as TElement} from "app/types/element";
import {type View as TView} from "app/types/element";

export function View({element, parent, children}: {
  element: TView;
  parent?: TElement;
  children?: ReactNode;
}) {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '1px solid lime', margin: 20, padding: 20}}>
      <h4>type: {element.type}, parent: {parent?.type}</h4>
      {children}
    </div>
  );
}

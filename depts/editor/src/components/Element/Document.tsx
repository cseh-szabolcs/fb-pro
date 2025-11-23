import {type ReactNode} from "react";
import {type Element as TElement} from "app/types/element";
import {type Document as TDocument} from "app/types/element";

export function Document({element, parent, children}: {
  element: TDocument;
  parent?: TElement;
  children?: ReactNode;
}) {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '1px solid red', margin: 20, padding: 20}}>
      <h4>type: {element.type}, parent: {parent?.type}</h4>
      {children}
    </div>
  );
}

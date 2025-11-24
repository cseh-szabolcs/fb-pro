import {type ReactNode} from "react";
import {type Element as TElement} from "app/types/element";
import {type Document as TDocument} from "app/types/element";

export function Document({element, parent, children}: {
  element: TDocument;
  parent?: TElement;
  children?: ReactNode;
}) {

  return (
    <div className="d-flex flex-column h-100" style={{backgroundColor: element.backgroundColor, border: '2px solid red', padding: 20}}>
      <h4>type: {element.type}, parent: {parent?.type}</h4>
      {children}
    </div>
  );
}

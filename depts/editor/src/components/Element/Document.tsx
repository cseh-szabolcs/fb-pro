import {type ReactNode} from "react";
import {type Document as TDocument} from "app/types/element";

export function Document({element, children}: {
  element: TDocument;
  children?: ReactNode;
}) {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '1px solid red', margin: 20, padding: 20}}>
      {children}
    </div>
  );
}

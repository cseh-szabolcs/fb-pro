import {type ReactNode} from "react";
import {type Element as TElement} from "app/types/element";
import {type Page as TPage} from "app/types/element";

export function Page({element, parent, children}: {
  element: TPage;
  parent?: TElement;
  children?: ReactNode;
}) {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '1px solid blue', margin: 20, padding: 20}}>
      <h4>type: {element.type}, parent: {parent?.type}</h4>
      {children}
    </div>
  );
}

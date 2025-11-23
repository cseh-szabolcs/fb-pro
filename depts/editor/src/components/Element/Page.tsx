import {type ReactNode} from "react";
import {type Page as TPage} from "app/types/element";

export function Page({element, children}: {
  element: TPage;
  children?: ReactNode;
}) {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '1px solid blue', margin: 20, padding: 20}}>
      {children}
    </div>
  );
}

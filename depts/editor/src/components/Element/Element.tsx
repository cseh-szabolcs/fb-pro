import {elements, type ElementProps} from "app/registry/elements.ts";
import './index.ts';
import {ElementContext} from "app/components/Element/ElementContext.tsx";

export function Element({element, parent, children}: ElementProps) {
  if (elements[element.type]) {
    const Component = elements[element.type];

    return (
      <ElementContext value={element}>
        <div dat-role-element={element.type} id={element.uuid}>
          <Component element={element} parent={parent} children={children}/>
        </div>
      </ElementContext>
    );
  }

  return (
    <div className="alert alert-warning">
      Cannot render element form type <b>{element.type}</b>!
    </div>
  );
}

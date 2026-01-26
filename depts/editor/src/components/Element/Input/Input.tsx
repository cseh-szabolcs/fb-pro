import {registerElement, type ElementProps} from "app/registry/elements.ts";

registerElement(({element, parent, children}: ElementProps) => {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '4px solid orange', padding: 20}}>
      <strong><code style={{color:'orange'}}>type: {element.type}, parent: {parent?.type}</code></strong><br />
      <small><code>uuid: {element.uuid}</code></small>
      {children}
    </div>
  );
}, 'input');

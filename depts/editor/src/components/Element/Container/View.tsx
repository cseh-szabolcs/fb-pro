import {registerElement, type ElementProps} from "app/registry/elements.ts";

registerElement(({element, parent, children}: ElementProps) => {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '2px solid limegreen', padding: 20}}>
      <strong><code style={{color:'limegreen'}}>type: {element.type}, parent: {parent?.type}</code></strong><br />
      <small><code>id: {element.id}</code></small>
      {children}
    </div>
  );
}, 'view');

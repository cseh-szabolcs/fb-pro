import {registerRenderer, type ElementProps} from "app/components/Element/renderer";

registerRenderer(({element, parent, children}: ElementProps) => {

  return (
    <div style={{backgroundColor: element.backgroundColor, border: '4px solid orange', margin: 20, padding: 20}}>
      <strong><code style={{color:'orange'}}>type: {element.type}, parent: {parent?.type}</code></strong><br />
      <small><code>uuid: {element.uuid}</code></small>
      {children}
    </div>
  );
}, 'input');

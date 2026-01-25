import {registerRenderer, type ElementProps} from "app/components/Element/renderer";

registerRenderer(({element, parent, children}: ElementProps) => {

  return (
    <div className="d-flex flex-column h-100" style={{backgroundColor: element.backgroundColor, border: '2px solid red', padding: 20}}>
      <strong><code style={{color:'red'}}>type: {element.type}, parent: {parent?.type}</code></strong><br />
      <small><code>uuid: {element.uuid}</code></small>
      {children}
    </div>
  );
}, 'document');

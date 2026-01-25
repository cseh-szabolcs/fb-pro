import {elements, type ElementProps} from "app/components/Element/renderer.ts";
import './Element/index.ts';

export function Element({element, parent, children}: ElementProps) {
    if (elements[element.type]) {
        const Component = elements[element.type];

        return (
            <div dat-role-element={element.type} id={element.uuid}>
                <Component element={element} parent={parent} children={children} />
            </div>
        );
    }

    return (
        <div className="alert alert-warning">
            Cannot render element form type <b>{element.type}</b>!
        </div>
    );
}

import {type ElementProps} from "app/components/Element/renderer.ts";
import {Element} from "app/components/Element.tsx";

export function FixtureElement(props: ElementProps) {

  return (
    <Element {...props} />
  );
}

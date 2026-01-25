import {Element} from "app/components/Element.tsx";
import {type ElementProps} from "app/components/Element/renderer.ts";
import type {FixtureData, FixtureElement as TFixtureElement} from "app/types/fixture.ts";

export function FixtureElement(props: ElementProps) {

  return (
    <div style={{border: "4px solid orange", background: 'yellow', margin: 10}}>
      <Element {...props} />
      <Data {...(props.element as TFixtureElement).fixtureData} />
    </div>
  );
}

function Data({
  category,
  name,
  description,
  tags,
}: FixtureData) {

  return (
    <code>
      category: {category}<br />
      name: {name}<br />
      description: {description}<br />
      tags: {JSON.stringify(tags)}<br />
    </code>
  );
}

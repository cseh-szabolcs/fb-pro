import {Element} from "app/components/Element.tsx";
import {type ElementProps} from "app/components/Element/renderer.ts";
import type {FixtureData, FixtureElement as TFixtureElement} from "app/types/fixture.ts";

export function FixtureElement(props: ElementProps) {
  const fixtureData = (props.element as TFixtureElement).fixtureData;

  if (!fixtureData) {
    return (
      <Element {...props} />
    );
  }

  return (
    <div style={{border: "4px solid orange", background: 'yellow', margin: 10}}>
      <Element {...props} />
      <Data {...fixtureData} />
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

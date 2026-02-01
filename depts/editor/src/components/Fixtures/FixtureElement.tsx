import {Element} from "app/components/Element/Element.tsx";
import {Draggable} from "app/ui/Dnd";
import type {ElementProps} from "app/registry/elements.ts";
import type {FixtureData, FixtureElement as TFixtureElement} from "app/types/fixture.ts";

export function FixtureElement(props: ElementProps) {
  const fixtureData = (props.element as TFixtureElement).fixtureData;

  if (!fixtureData) {
    return (
      <Element {...props} />
    );
  }

  return (
    <Draggable id={`${props.element.uuid}-draggable`}>
      <div style={{border: "4px solid orange", background: 'yellow', margin: 10}}>
        <Element {...props} />
        <Data {...fixtureData} />
      </div>
    </Draggable>
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

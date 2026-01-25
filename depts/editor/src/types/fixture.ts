import type {Element} from "./element.ts";

export interface FixtureElement extends Element {
  fixtureData?: FixtureData;
}

export interface FixtureData {
  category: string,
  name: string,
  description: string,
  tags: string[],
}

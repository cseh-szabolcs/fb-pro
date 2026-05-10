import type {BaseElement} from "./element.ts";

export interface FixtureElement extends BaseElement {
  fixtureData?: FixtureData;
}

export interface FixtureData {
  category: string,
  name: string,
  description: string,
  tags: string[],
}

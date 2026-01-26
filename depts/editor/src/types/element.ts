import type {Corner, Side} from "app/types/element/props.ts";

interface ElementData {
  uuid: string;
  type: string;
  role?: string;
  position: number;
  backgroundColor?: string;
  color?: string;
  directionRow?: boolean;
  margin?: Side<number>;
  padding?: Side<number>;
  borderWidth?: Side<number>;
  borderColor?: Side<string>;
  borderRadius?: Corner;
  supportedTypes?: string[];
}

// element in editor (frontend)
export interface Element extends ElementData {
  children: string[];
}

// element from api (backend)
export interface ResponseElement extends ElementData {
  parent?: ResponseElement;
  children: ResponseElement[];
}

export interface Document extends Element {
  type: 'document';
}

export interface Page extends Element {
  type: 'page';
}

export interface View extends Element {
  type: 'view';
}
